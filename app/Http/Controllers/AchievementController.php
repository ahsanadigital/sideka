<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Achievement;
use App\Http\Requests\StoreAchievementRequest;
use App\Http\Requests\UpdateAchievementRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AchievementController extends Controller
{
    private Achievement $_achievementModel;
    private DataTables $_datatables;
    private ResponseHelper $_responseHelper;

    public function __construct(Achievement $achievement, DataTables $datatables, ResponseHelper $responseHelper)
    {
        $this->_achievementModel = $achievement;
        $this->_datatables = $datatables;
        $this->_responseHelper = $responseHelper;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->_achievementModel->query()
                ->when($request->input('council_level'), function ($query, $authorLevel) {
                    return $query->whereHas('user.roles', function ($query) use ($authorLevel) {
                        $query->where('name', $authorLevel);
                    });
                });
            return $query->paginate(16);
        }

        if ($request->route()->getPrefix() === 'api') {
            return abort(403);
        }

        return view('page.panel.achievement.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAchievementRequest $request)
    {
        try {
            $data = collect($request->validated());
            $achievementData = $this->_achievementModel->create($data->except(['files'])->toArray());
            $achievementData->addMultipleMediaFromRequest(['files'])->each(fn($files) => $files->toMediaCollection('achievement-photos'));

            return $this->_responseHelper->success();
        } catch (\Exception $e) {
            return $this->_responseHelper->error($data = [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement, Request $request)
    {
        $achievement->load('user');

        $achievementPhoto = $achievement->getMedia('achievement-photos')->map(function ($item) {
            return [
                'url' => $item->getUrl(),
                'id' => $item->getAttribute('id'),
                'thumbnail' => $item->getUrl('achievement-media-thumbnail'),
            ];
        })->toArray();

        // Assign the attribute photo and docs for achievement data
        $achievement->setAttribute('photos', $achievementPhoto);

        if ($request->ajax()) {
            return $this->_responseHelper->success($achievement);
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAchievementRequest $request, Achievement $achievement)
    {
        try {
            $data = collect($request->validated());
            $achievement->update($data->except(['files'])->toArray());

            if($request->has('files')) {
                $files = $achievement->addMultipleMediaFromRequest(['files']);
                foreach ($files as $file) {
                    $file->toMediaCollection('achievement-photos');
                }
            }

            return $this->_responseHelper->success();
        } catch (\Throwable $th) {
            return $this->_responseHelper->error($th->getMessage());
        } catch(\Exception $e) {
            return $this->_responseHelper->error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        try {
            $achievement->delete();
            return $this->_responseHelper->success();
        } catch (\Throwable $th) {
            return $this->_responseHelper->error($th->getMessage());
        } catch(\Exception $e) {
            return $this->_responseHelper->error($e->getMessage());
        }
    }
}
