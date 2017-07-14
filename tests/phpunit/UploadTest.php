<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

require_once('../../src/php/upload.php');
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{

    public function testExecute(){
        $upload = new Upload();
        $response = $upload->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");

        $upload->initTestData('image','maikelele.png');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong");

    }

}
