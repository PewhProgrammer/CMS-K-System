<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 7/14/2017
 * Time: 1:33 PM
 */
$result=exec("python cache/bus.py");
$shipments = file_get_contents("cache/bus_1.json", "r");
echo $shipments;