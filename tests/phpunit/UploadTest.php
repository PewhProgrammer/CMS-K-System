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

        $_POST['test'] = true;

        $upload->initTestData('jpg','C:\Users\Thinh-Laptop\Desktop\Test.jpg','../uploads/Test.jpg');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $_POST['test'] = null;

        $query = new Query("DELETE FROM resources WHERE name = '../uploads/Test.jpg'");
        $query->executeQuery();
        $response = $query->getResponse();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $upload->initTestData('ics','maikelele.ics','maikelele.jpg');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());

        $upload->initTestData('pdf','maikelele.pdf','maikelele.pdf');
        $response = $upload->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }

    public function testConstructor(){
        $_FILES["userfile"]["name"] =  'C:\Users\Thinh-Laptop\Desktop\Test.txt';
        $_FILES["userfile"]["tmp_name"] = 'C:\Users\Thinh-Laptop\Desktop\Test.txt';
        $upload = new Upload();
        $response = $upload->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");
    }

}
