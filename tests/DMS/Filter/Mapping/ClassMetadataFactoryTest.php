<?php

namespace DMS\Filter\Mapping;

class ClassMetadataFactoryTest extends \Tests\Testcase
{

    /**
     * @var ClassMetadataFactory
     */
    protected $factory;

    public function setUp()
    {
        parent::setUp();
        
        $this->factory = $this->buildMetadataFactory();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testGetClassMetadata()
    {
        $metadata = $this->factory->getClassMetadata('Tests\Dummy\Classes\AnnotatedClass');
        
        $this->assertInstanceOf('DMS\Filter\Mapping\ClassMetadataInterface', $metadata);
    }

    public function testParsedMetadataFromFactory()
    {
        $metadata = $this->factory->getClassMetadata('Tests\Dummy\Classes\AnnotatedClass');
        
        $metadataReparsed = $this->factory->getClassMetadata('Tests\Dummy\Classes\AnnotatedClass');
        
        $this->assertSame($metadata, $metadataReparsed);
        
    }
    
    public function testCachedMetadataFromFactory()
    {
        $cache = new \Doctrine\Common\Cache\ArrayCache();
        
        $this->factory = new ClassMetadataFactory($this->loader, $cache);
        
        $metadata = $this->factory->getClassMetadata('Tests\Dummy\Classes\AnnotatedClass');
        
        $this->assertTrue($cache->contains(ltrim('Tests\Dummy\Classes\AnnotatedClass', '\\')));
        
        //Get new Factory to retrieve from cache
        $this->factory = new ClassMetadataFactory($this->loader, $cache);
        $metadataCached = $this->factory->getClassMetadata('Tests\Dummy\Classes\AnnotatedClass');
        
        $this->assertEquals($metadata, $metadataCached);
    }
}

?>
