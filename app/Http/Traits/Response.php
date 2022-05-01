<?php
namespace App\Http\Traits;

/**
 * @author Daniel Ozeh hello@danielozeh.com.ng
 */

trait Response {
    public function response($status, $message, $status_code = null) {

        return response()->json([
            'status' => $status,
            'message' => $message
        ], $status_code);
    }

    public function successResponse($message,$status_code) {
        return response()->json([
            'status' => 'success',
            'message' => $message
        ],$status_code);
    }
    public function failedResponse($message, $status_code) {
            return response()->json([
                'status' => 'failed',
                'message' => $message
            ], $status_code);
        }
    public function internalServerError($message) {
            return response()->json([
                'status' => 'failed',
                'message' => $message
            ], 500);
        }
    public function validationError($message) {
            return response()->json([
                'status' => 'failed',
                $message
            ], 400);
        }
}
