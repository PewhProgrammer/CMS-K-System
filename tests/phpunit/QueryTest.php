<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:22
 */

use PHPUnit\Framework\TestCase;

class QueryTest extends TestCase
{

    public function testWrongSQLFormat(){

        $query = new Query('INSERT INTO bla');
        try {
            $query->executeQuery();
            self::fail();
        } catch (Exception $e) {
            echo 'Exception caught: ',  $e->getMessage(), "\n";
        }

        try {
            $query->getQuery();
            self::fail();
        } catch (Exception $e) {
            echo 'Exception caught: ',  $e->getMessage(), "\n";
        }


    }
}
