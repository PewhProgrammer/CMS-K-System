<?php
include_once "Query.php";
/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 06.07.2017
 * Time: 18:29
 */
abstract class Events
{
    protected $query;
    /**
     * Events constructor.
     */
    abstract public function __construct();

    /**
     * @return Response The return value shall be a Response
     */
    abstract public function execute();

    /**
     * Checks if the params are set correctly
     * @return bool The return value shall be a Boolean
     */
    abstract protected function verify();
}