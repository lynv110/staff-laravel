<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class UploadController extends Controller {
    public function upload() {
        $json = [];

        $directory = config('image.path');

        if (!$json) {
            $file = \Request::file('file');

            if (!empty($file->getClientOriginalName()) && is_file($file->getPathname())) {
                // Sanitize the filename
                $filename = basename(html_entity_decode($file->getClientOriginalName(), ENT_QUOTES, 'UTF-8'));

                // Validate the filename length
                if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
                    $json['error'] = trans('main.error_filename');
                }

                // Allowed file extension types
                $allowed = array(
                    'jpg',
                    'jpeg',
                    'gif',
                    'png'
                );

                if (!in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $allowed)) {
                    $json['error'] = trans('error_filetype');
                }

                // Allowed file mime types
                $allowed = array(
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/x-png',
                    'image/gif'
                );

                if (!in_array($file->getMimeType(), $allowed)) {
                    $json['error'] = trans('error_filetype');
                }

                // Return any upload error
                if ($file->getError() != UPLOAD_ERR_OK) {
                    $json['error'] = trans('error_error');
                }
            } else {
                $json['error'] = trans('error_error');
            }

            if (!$json) {
                move_uploaded_file($file->getPathname(), $directory . '/' . $filename);
            }
        }

        if (!$json) {
            $json['success'] = trans('main.text_uploaded');
            $json['info'] = [
                'thumb' => image_fit($filename, 100, 100),
                'filename' => $filename,
            ];
        }

        return Response::json($json);
    }
}
