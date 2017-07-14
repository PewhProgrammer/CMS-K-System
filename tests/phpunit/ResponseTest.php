<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

use PHPUnit\Framework\TestCase;

require_once('../../src/php/Response.php');

class ResponseTest extends TestCase
{

    public function testFunctionModule(){
        $response = new Response('200','Message');

        $this->assertEquals('200',$response->getCode(),'Wrong code returned');
        $this->assertEquals('Message',$response->getMsg(),'Wrong Message returned');
        $response->setCode(400);
        $this->assertEquals('400',$response->getCode(),'Wrong code returned');
        $response->setMsg('Number');
        $this->assertEquals('Number',$response->getMsg(),'Wrong Message returned');
    }

}
