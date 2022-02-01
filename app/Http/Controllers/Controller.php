<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function respon(string $status = 'error', string $message = 'error', $error = null, $content = null, $statusCode = 200)
    {
        $respon = [
            'status'    => $status,
            'message'   => $message,
            'error'     => $error,
            'content'   => $content,
        ];
        return response()->json($respon, $statusCode);
    }
}
