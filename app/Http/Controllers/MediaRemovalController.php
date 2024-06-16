<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaRemovalController extends Controller
{
    private ResponseHelper $_responseHelper;

    public function __construct()
    {
        $this->_responseHelper = new ResponseHelper();
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Media $media, Request $request)
    {
        try {
            $media->delete();

            return $this->_responseHelper->success();
        } catch (\Throwable $th) {
            return $this->_responseHelper->error($th->getMessage());
        } catch(\Exception $e) {
            return $this->_responseHelper->error($e->getMessage());
        }
    }
}
