<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UploadService
{
    public function uploadToCloudinary($file)
    {
        $timestamp = time();

        $signature = sha1("timestamp={$timestamp}" . env('CLOUDINARY_API_SECRET'));

        $response = Http::asMultipart()->post(
            "https://api.cloudinary.com/v1_1/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload",
            [
                'file' => fopen($file->getRealPath(), 'r'),
                'api_key' => env('CLOUDINARY_API_KEY'),
                'timestamp' => $timestamp,
                'signature' => $signature,
            ]
        );

        return $response->json(); // trả về url + public_id
    }


// config .env
// CLOUDINARY_API_SECRET=your_secret_here
// CLOUDINARY_API_KEY=your_api_key
// CLOUDINARY_CLOUD_NAME=your_cloud_name

    public function cloudinary_signature(array $paramsToSign): string {
        // Loại bỏ file, api_key, cloud_name, resource_type nếu có
        // $paramsToSign là associative array của các param bạn muốn sign,
        // ví dụ ['timestamp' => ..., 'public_id' => 'my_image', 'folder' => 'avatars']

        // 1. sort params by key
        ksort($paramsToSign);

        // 2. build string param1=val1&param2=val2...
        $stringToSign = http_build_query($paramsToSign, '', '&', PHP_QUERY_RFC3986);

        // 3. append api_secret
        $stringToSign .= env('CLOUDINARY_API_SECRET');

        // 4. sha1 hash
        return sha1($stringToSign);
    }

    public function generateSignature() {

        // Ví dụ sử dụng:
        $params = [
            'timestamp' => time(),
            'folder' => "resume"
        ];
        $signature = $this->cloudinary_signature($params);

        return response()->json([
            'api_key' => env('CLOUDINARY_API_KEY'),
            'timestamp' => $params['timestamp'],
            'signature' => $signature,
            // truyền thêm các param khác nếu cần (public_id, folder, ...)
        ]);
    }
}