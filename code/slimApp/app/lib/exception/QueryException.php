<?php


namespace App\Lib\Exception;


class QueryException
{
    private $message;
    private $code;

    /**
     * QueryException constructor.
     * @param $message
     * @param $code
     */
    public function __construct($message, $code)
    {
        $this->message = ($message);
        $this->code = $code;
    }


    public function getErrorMessage() {
        return [
            'message' => json_decode($this->message)
        ];
    }

    public function getCode() {
        return $this->code;
    }
}