<?php

namespace App\ApiResponse;

class Response
{
    private ?string $message = null ;
    private mixed $data = null; 
    private int $status = 200 ;
    private array $appends = [];
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
    public function setData(mixed $data){
        $this->data = $data;
    }
    public function setStatus(int $status)
    {
        $this->status = $status;
    }
    public function setAppends(array $appends)
    {
        $this->appends = $appends;
    }
    public function response()
    {
        $body = [];
        if ($this->message !== null) {
            $body['message'] = $this->message;
        }
        if ($this->data !== null) {
            $body['data'] = $this->data;
        }
        $body = $body + $this->appends;
        return response()->json($body, $this->status);
    }
    
}
