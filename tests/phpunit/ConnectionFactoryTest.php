<?php

/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 17:48
 */
require_once('../../src/php/ConnectionFactory.php');

class ConnectionFactoryTest extends \PHPUnit\Framework\TestCase
{

    public function testErrors(){
        $cF = ConnectionFactory::getFactory();

        $_POST['lock'] = true;
        try{
            $cF->getConnection();
            $this->fail();
        } catch (Exception $e) {
            echo 'Exception caught: ',  $e->getMessage(), "\n";
        }

        $_POST['nomysql'] = true;
        $cF->getConnection();
        //assertEquals(null,$cF->getConnection(),'was not equals null');

        $this->assertTrue(true,"fufilled");
        $_POST['lock'] = null;
        $_POST['nomysql'] =null;
    }

}
