<?php

namespace App\Http\Controllers;

use App\Services\UploadService;

class FileController extends Controller
{
    protected $uploadService;

    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function generateUrl()
    {
        return $this->uploadService->generateSignature();
    }
}
