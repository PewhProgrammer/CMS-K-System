<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

require_once('../../src/php/Delete.php');

class DeleteTest extends \PHPUnit\Framework\TestCase
{

    public function setUp(){
    }


    public function testWebsiteSuccess()
    {
        $resource = new Resource('testWebsite','www.google.com','website');
        $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $resource->getName() .
            "', '" . $resource->getType() . "', '" . $resource->getData() . "')");
        $query->executeQuery();

        $delete = new Delete();
        $query = new Query("SELECT * FROM resources WHERE name = 'testWebsite'");
        $res = $query->getQuery();
        $resource = $res->fetch_assoc();
        $response = $delete->execute();
        $this->assertEquals(404, $response->getCode(), "Response code was wrong: ".$response->getMsg());

        $_POST["id"] = $resource["rID"];
        $response = $delete->execute();

        $this->assertEquals(200, $response->getCode(), "Response code was wrong: ".$response->getMsg());
    }


    public function testPDFSuccess()
    {
        $resource = new Resource('testPDF','www.google.com','pdf');
        $query = new Query("INSERT INTO resources (name, type, data) VALUES ('" . $resource->getName() .
            "', '" . $resource->getType() . "', '" . $resource->getData() . "')");
        $query->executeQuery();

        $delete = new Delete();
        $query = new Query("SELECT * FROM resources WHERE name = 'testPDF'");
        $res = $query->getQuery();
        $resource = $res->fetch_assoc();
        $_POST["id"] = $resource["rID"];

        $response = $delete->execute();

        $this->query = new Query("DELETE FROM resources WHERE rID=" . $resource["rID"]);
        $this->query->executeQuery();

        $this->assertEquals(200, $response->getCode(), "Response code was wrong: ".$response->getMsg());
    }



}
