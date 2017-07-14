<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

require_once('../../src/php/delete.php');

class DeleteTest extends \PHPUnit\Framework\TestCase
{
    public function testReason()
    {
        $delete = new Delete();
        $this->assertEquals(0, $delete->getResource(), "Id should be 0");

        $query = new Query("SELECT * FROM resources WHERE name = 'test'");
        $res = $query->getQuery();
        $resource = $res->fetch_assoc();
        $delete->setResource($resource["rID"]);

        $response = $delete->execute();

        $this->assertEquals(200, $response->getCode(), "Response code was wrong");
    }

    public function deleteNormalConstructor() {
        $_POST["id"] = 5;
        $delete = new Delete();
        $this->assertEquals(5, $delete->getResource(), "Id should be 5");
    }

}
