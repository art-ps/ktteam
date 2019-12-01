<?php

namespace TaskTracker\Http\Controller;

abstract class BaseController
{
    /**
     * Send response
     *
     * @param  mixed $data
     *
     * @return void
     */
    public function sendResponse($data)
    {
        $message = [];
        $code = 200;
       
        if ($data) {
            if (is_array($data)) {
                $message = $data;
            } elseif (is_bool($data)) {
                $message[] = $data ? 'Success' : 'Error';
                $code = $data ? 200 : 400;
            } else {
                $message = $data->toArray();
            }
        }

        return $this->response($message, $code);
    }

    /**
     * Create response
     *
     * @param  array $message
     * @param  int $code
     *
     * @return void
     */
    public function response($message = null, int $code = 200)
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');

        $status = [
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        ];

        header('Status: '.$status[$code]);

        echo json_encode([
            'status' => $code < 300,
            'message' => $message
        ]);
    }
}
