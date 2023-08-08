<?php

namespace App\Traits;

trait HttpResponses {

    protected function success ($message, $data = [], $code = 200) {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error ($message, $data = null, $code = 422) {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
