<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

require_once('../../src/php/Upload.php');
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{

    public function testExecute(){
        $upload = new Upload();
        $response = $upload->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");

        $upload->initTestData('jpg','maikelele.jpg','maikelele.jpg');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $upload->initTestData('ics','maikelele.ics','maikelele.jpg');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $upload->initTestData('pdf','maikelele.pdf','maikelele.jpg');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

    }

}
