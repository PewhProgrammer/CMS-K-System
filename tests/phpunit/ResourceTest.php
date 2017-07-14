<?php
/**
 * Created by PhpStorm.
 * User: Thinh-Laptop
 * Date: 13.07.2017
 * Time: 21:23
 */

use PHPUnit\Framework\TestCase;

require_once('../../src/php/Resource.php');

class ResourceTest extends TestCase
{

    public function testFunctionModule(){
        $resource = new Resource('highschool','path/to/image','image');

        $this->assertEquals('highschool',$resource->getName(),'Wrong name');
        $this->assertEquals('path/to/image',$resource->getData(),'Wrong data');
        $this->assertEquals('image',$resource->getType(),'Wrong type');

        $resource->setName('mama');
        $this->assertEquals('mama',$resource->getName(),'Wrong name');
        $resource->setData('path/to/pdf44');
        $this->assertEquals('path/to/pdf44',$resource->getData(),'Wrong data');
        $resource->setType('pdf');
        $this->assertEquals('pdf',$resource->getType(),'Wrong type');
    }

}
