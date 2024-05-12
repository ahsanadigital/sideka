<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UtilsController extends Controller
{
    /**
     * Controll the download file action
     */
    public function downloadFile(Request $request): ?BinaryFileResponse
    {
        $request->validate([
            'path' => 'required',
            'name' => 'required',
        ]);

        return FileService::download($request->input('path'), $request->input('name'));
    }
}
