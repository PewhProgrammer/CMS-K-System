<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */


require_once('../../src/php/UserHandler.php');
require_once('../../src/php/User.php');

use PHPUnit\Framework\TestCase;

class UserHandlerTest extends TestCase
{

    public function testExecute(){
        $login = new UserHandler();
        $response = $login->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong");

        $login->initTestData(new User('curd','wrongPW'));
        $response = $login->execute();
        $this->assertEquals(404,$response->getCode(),"Response code was wrong: ");

        $login->initTestData(new User('curd','curd'));
        $response = $login->execute();
        $this->assertEquals(200,$response->getCode(),"Response code was wrong: ");
    }

}
