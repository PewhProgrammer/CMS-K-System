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

        $query = new Query("SELECT * FROM resources WHERE name = 'test'");
        $res = $query->getQuery();
        $resource = $res->fetch_assoc();
        $delete->setResource($resource["rID"]);

        $response = $delete->execute();

        $this->assertEquals(200, $response->getCode(), "Response code was wrong");
    }
}
