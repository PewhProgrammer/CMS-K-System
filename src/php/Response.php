<?php

/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 05.07.2017
 * Time: 10:50
 */
class Response
{
    private $code;
    private $msg;

    /**
     * Response constructor.
     * @param $code
     * @param $msg
     */
    public function __construct($code, $msg)
    {
        $this->code = $code;
        $this->msg = $msg;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }

    /**
     * @param mixed $msg
     */
    public function setMsg($msg)
    {
        $this->msg = $msg;
    }

}