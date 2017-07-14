<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:22
 */

use PHPUnit\Framework\TestCase;

require '../../src/php/attach.php';

class AttachTest extends TestCase
{
    public function testReason(){
        $attach = new Attach();
        $resources = array(1,2);
        $monitors = array(3,4);
        $attach->setResources($resources, $monitors, "");
        $response = $attach->execute();

        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }
}
