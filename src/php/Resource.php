<?php

/**
 * Created by PhpStorm.
 * User: Jonas
 * Date: 05.07.2017
 * Time: 11:26
 */
class Resource
{
    private $name;
    private $data;
    private $type;

    /**
     * Resource constructor.
     * @param $name
     * @param $data
     * @param $type
     */
    public function __construct($name, $data, $type)
    {
        $this->name = $name;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

}