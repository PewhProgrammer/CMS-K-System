<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */


require_once('../../src/php/server_login.php');
require_once('../../src/php/User.php');

use PHPUnit\Framework\TestCase;

class UserHandlerTest extends TestCase
{

    public function testExecute(){
        $login = new UserHandler();
        $response = $login->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");

        $login->initTestData(new User('curd','a1cf52f3879ca4ee972837d4115a335eb5e77bb52abd15ee89c5c51bb5663c70'));
        $response = $login->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ".$response->getMsg());
    }

}
