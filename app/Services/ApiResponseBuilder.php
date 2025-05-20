<?php

namespace App\Services;

class ApiResponseBuilder
{
    protected $response = [
        'status' => true,
        'message' => '',
        'data' => null,
        'errors' => []
    ];

    public function setStatus(bool $status)
    {
        $this->response['status'] = $status;
        return $this;
    }

    public function setMessage(string $message)
    {
        $this->response['message'] = $message;
        return $this;
    }

    public function setData($data)
    {
        $this->response['data'] = $data;
        return $this;
    }

    public function setErrors(array $errors)
    {
        $this->response['errors'] = $errors;
        return $this;
    }

    public function build()
    {
        return response()->json($this->response);
    }
}
