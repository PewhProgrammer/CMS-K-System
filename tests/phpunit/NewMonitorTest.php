<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:24
 */

use PHPUnit\Framework\TestCase;

require_once('../../src/php/NewMonitor.php');

class NewMonitorTest extends TestCase
{
    public function testFunctionModule(){

        $_POST["mID"] = null;
        $_POST['name'] = null;
        $nM = new newMonitor();
        $nM->execute();

        $response = $nM->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $_POST['mID'] = 100000;
        $nM = new newMonitor();
        $response = $nM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $_POST['name'] = 'testName';
        $_POST['alignment'] = 1;
        $_POST['location'] = 4;
        $response = $nM->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $name = 'testName';
        $query = new Query("DELETE FROM monitorhaslabel WHERE mID = 100000");
        $query->executeQuery();
        $query = new Query("DELETE FROM monitors WHERE mID = 100000");
        $query->executeQuery();

        $_POST['mID'] = null;
        $_POST['name'] = null;
        $_POST['alignment'] = null;
        $_POST['location'] = null;
    }
}
