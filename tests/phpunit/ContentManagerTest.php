<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 14.07.2017
 * Time: 13:53
 */

use PHPUnit\Framework\TestCase;

require '../../src/php/ContentManager.php';

class ContentManagerTest extends TestCase
{
    public function testExecute(){
        $contentManager = new ContentManager();
        $response = $contentManager->execute();
        echo $response;

        $this->assertEquals(200,$response->getCode(),"Response code was wrong");
    }

}
