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
    private FileService $fileService;
    private ResponseHelper $responseHelper;
    private Decree $decreeModel;
    private DataTables $datatables;
    private DateService $dateService;

    public function __construct()
    {
        $this->datatables = datatables();
        $this->dateService = new DateService();
        $this->fileService = new FileService();
        $this->decreeModel = new Decree();
        $this->responseHelper = new ResponseHelper();
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
            $decreeData = $this->datatables->eloquent($this->decreeModel->query())
                ->addColumn('user', function (Decree $decree) {
                    return $decree->user->toArray();
                })
                ->toJson();

            return $decreeData;
        }

        return view('page.panel.decree.index');
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
    public function store(StoreDecreeRequest $request)
    {
        try {
            $data = $request->validated();
            $data['document'] = $this->fileService->upload($request, 'decree');
            $data['start_from'] = $this->dateService->convertToPreferredTimezone($request->input('start_from'));
            $data['end_to'] = $this->dateService->convertToPreferredTimezone($request->input('end_to'));

            $this->decreeModel->create($data);

            return $this->responseHelper->success();
        } catch (\Exception $e) {
            $this->fileService->remove($data['file']);

            return $this->responseHelper->error($data = [
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Decree $decree, Request $request)
    {
        $decree->load('user');

        // Load and assign document information
        $documentInfo = $decree->getFileInformation();
        $decree->setAttribute('document', $documentInfo);

        if ($request->ajax()) {
            return $this->responseHelper->success($decree);
        }

        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Decree $decree)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDecreeRequest $request, Decree $decree)
    {
        try {
            $data = $request->validated();
            $data['start_from'] = $this->dateService->convertToPreferredTimezone($request->input('start_from'));
            $data['end_to'] = $this->dateService->convertToPreferredTimezone($request->input('end_to'));

            if($request->file('document')) {
                $data['document'] = $this->fileService->upload($request, 'decree');
            }

            $decree->update($data);

            return $this->responseHelper->success([
                'request' => $data
            ]);
        } catch (\Exception $e) {
            $this->fileService->remove($data['file']);

            return $this->responseHelper->error($data = [
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
            $this->fileService->remove($decree->getAttribute('document'));
            $decree->delete();

            return $this->responseHelper->success();
        } catch (\Exception $e) {
            return $this->responseHelper->error([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
