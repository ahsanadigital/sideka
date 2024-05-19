<?php

namespace App\Http\Controllers;

use App\Models\Decree;
use App\Models\Meeting;
use App\Models\Member;
use App\Services\FileService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UtilsController extends Controller
{
    private Decree $_decreeModel;
    private Meeting $_meetingModel;
    private Member $_memberModel;

    public function __construct()
    {
        $this->_memberModel = new Member();
        $this->_meetingModel = new Meeting();
        $this->_decreeModel = new Decree();
    }

    /**
     * Control the download file action
     */
    public function downloadFile(Request $request): ?BinaryFileResponse
    {
        $request->validate([
            'path' => 'required',
            'name' => 'required',
        ]);

        return FileService::download($request->input('path'), $request->input('name'));
    }

    /**
     * Provide API for search all Data
     */
    public function searchData(Request $request)
    {
        try {
            $meetingData = $this->_meetingModel->where("title", "LIKE", "%{$request->input('search')}%");
            $decreeData = $this->_decreeModel->where("title", "LIKE", "%{$request->input('search')}%");
            $memberData = $this->_memberModel->where("name", "LIKE", "%{$request->input('search')}%");
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
