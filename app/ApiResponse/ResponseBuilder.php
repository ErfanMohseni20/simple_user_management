<?php

namespace App\ApiResponse;
use App\ApiResponse\Response;

class ResponseBuilder {

    private response $response;
    public function __construct()
    {
        $this->response = new \App\ApiResponse\Response();
    }
    public function message(string $message)
    {
         $this->response->setMessage($message);
         return $this;
    }
    public function data(mixed $data){
         $this->response->setData($data);
         return $this;
    }
    public function status(int $status){
         $this->response->setStatus($status);
         return $this;
    }
    public function appends(array $appends){
         $this->response->setAppends($appends);
         return $this;
    }
    public function build()
    {
        return $this->response->response();
    }
}
