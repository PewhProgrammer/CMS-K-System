<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:24
 */

use PHPUnit\Framework\TestCase;

require_once('../../src/php/User.php');

class UserTest extends TestCase
{
    public function testFunctionModule(){
        $user = new User('John','bolton');
        $this->assertEquals('John',$user->getUsername(),'Wrong Username returned');
        $this->assertEquals('bolton',$user->getPassword(),'Wrong Username returned');
        $user->setUsername('Mike');
        $this->assertEquals('Mike',$user->getUsername(),'Wrong Username returned');
        $user->setPassword('ramsay');
        $this->assertEquals('ramsay',$user->getPassword(),'Wrong Username returned');
    }
}
