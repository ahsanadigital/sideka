<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Decree;
use App\Http\Requests\StoreDecreeRequest;
use App\Http\Requests\UpdateDecreeRequest;
use App\Services\DateService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DecreeController extends Controller
{
    private FileService $_fileService;
    private ResponseHelper $_responseHelper;
    private Decree $_decreeModel;
    private DataTables $_datatables;
    private DateService $_dateService;

    public function __construct()
    {
        $this->_datatables = datatables();
        $this->_dateService = new DateService();
        $this->_fileService = new FileService();
        $this->_decreeModel = new Decree();
        $this->_responseHelper = new ResponseHelper();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->_decreeModel->query()
                ->when($request->input('council_level'), function ($query, $authorLevel) {
                    return $query->whereHas('user.roles', function ($query) use ($authorLevel) {
                        $query->where('name', $authorLevel);
                    });
                })
                ->when($request->input('category'), function ($query, $category) {
                    return $query->where('council_category_id', $category);
                });

            $decreeData = $this->_datatables->eloquent($query)
                ->addColumn('user', function (Decree $decree) {
                    return $decree->user->toArray();
                })
                ->toJson();

            return $decreeData;
        }

        if ($request->route()->getPrefix() === 'api') {
            return abort(403);
        }

        return view('page.panel.decree.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not Being Used
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDecreeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['document'] = $this->_fileService->upload($request, 'decree');
            $data['start_from'] = $this->_dateService->convertToPreferredTimezone($request->input('start_from'));
            $data['end_to'] = $request->input('end_to') ? $this->_dateService->convertToPreferredTimezone($request->input('end_to')) : null;

            $this->_decreeModel->create($data);

            return $this->_responseHelper->success();
        } catch (\Exception $e) {
            $this->_fileService->remove($data['file']);

            return $this->_responseHelper->error($data = [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Decree $decree, Request $request)
    {
        $decree->load('user', 'category');

        // Load and assign document information
        $documentInfo = $decree->getFileInformation();
        $decree->setAttribute('document', $documentInfo);

        if ($request->ajax()) {
            return $this->_responseHelper->success($decree);
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Decree $decree)
    {
        // Not Being Used
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDecreeRequest $request, Decree $decree)
    {
        try {
            $data = $request->validated();
            $data['start_from'] = $this->_dateService->convertToPreferredTimezone($request->input('start_from'));
            $data['end_to'] = $this->_dateService->convertToPreferredTimezone($request->input('end_to'));

            if ($request->file('document')) {
                $data['document'] = $this->_fileService->upload($request, 'decree');
            }

            $decree->update($data);

            return $this->_responseHelper->success([
                'request' => $data
            ]);
        } catch (\Exception $e) {
            $this->_fileService->remove($data['file']);

            return $this->_responseHelper->error($data = [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Decree $decree)
    {
        try {
            $this->_fileService->remove($decree->getAttribute('document'));
            $decree->delete();

            return $this->_responseHelper->success();
        } catch (\Exception $e) {
            return $this->_responseHelper->error([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
