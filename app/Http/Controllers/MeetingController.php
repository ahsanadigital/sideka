<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Meeting;
use App\Http\Requests\StoreMeetingRequest;
use App\Http\Requests\UpdateMeetingRequest;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Yajra\DataTables\DataTables;

class MeetingController extends Controller
{
    private Meeting $_meetingModel;
    private DataTables $_datatables;
    private ResponseHelper $_responseHelper;

    public function __construct()
    {
        $this->_datatables = datatables();
        $this->_responseHelper = new ResponseHelper();
        $this->_meetingModel = new Meeting();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->_datatables->eloquent($this->_meetingModel->query())
                ->addColumn('user', function (Meeting $meeting) {
                    return $meeting->getAttribute('user')->toArray();
                })
                ->toJson();
        }

        return view('page.panel.meeting.index');
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
    public function store(StoreMeetingRequest $request)
    {
        try {
            $data = collect($request->validated());

            $meetingData = $this->_meetingModel->create($data->except(['files', 'docs'])->toArray());

            $meetingData->addMultipleMediaFromRequest(['files'])->each(fn($files) => $files->toMediaCollection('meeting-photos'));
            $meetingData->addMediaFromRequest('docs')->toMediaCollection('meeting-docs');

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
    public function show(Meeting $meeting, Request $request)
    {
        $meeting->load('user', 'category');

        $meetingPhoto = $meeting->getMedia('meeting-photos')->map(function ($item) {
            return [
                'url' => $item->getUrl(),
                'id' => $item->getAttribute('id'),
                'thumbnail' => $item->getUrl('meeting-media-thumbnail'),
            ];
        })->toArray();

        $meetingDocs = $meeting->getMedia('meeting-docs')->map(function ($item) {
            return [
                'path' => $item->getPathRelativeToRoot(),
                'id' => $item->getAttribute('id'),
                'mime' => $item->getTypeFromMime(),
            ];
        })->first();

        // Assign the attribute photo and docs for meeting data
        $meeting->setAttribute('photos', $meetingPhoto);
        $meeting->setAttribute('docs', $meetingDocs);

        if ($request->ajax()) {
            return $this->_responseHelper->success($meeting);
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meeting $meeting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeetingRequest $request, Meeting $meeting)
    {
        try {
            $data = collect($request->validated());
            $meeting->update($data->except(['files', 'docs'])->toArray());

            if($request->has('docs')) {
                $meeting->addMediaFromRequest('docs')->toMediaCollection('meeting-docs');
            }

            if($request->has('files')) {
                $files = $meeting->addMultipleMediaFromRequest(['files']);
                foreach ($files as $file) {
                    $file->toMediaCollection('meeting-photos');
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
    public function destroy(Meeting $meeting)
    {
        try {
            $meeting->delete();
            return $this->_responseHelper->success();
        } catch (\Throwable $th) {
            return $this->_responseHelper->error($th->getMessage());
        } catch(\Exception $e) {
            return $this->_responseHelper->error($e->getMessage());
        }
    }
}
