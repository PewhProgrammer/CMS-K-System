<?php
include_once "dbquery.php";
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 06.07.2017
 * Time: 18:29
 */
abstract class ServerWrapper
{
    protected $query;
    /**
     * ServerWrapper constructor.
     */
    public function __construct()
    {

    }

    /**
     * @return Response The return value shall be a Response
     */
    abstract public function execute();
}