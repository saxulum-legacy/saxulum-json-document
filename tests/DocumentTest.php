<?php

namespace Saxulum\Tests\JsonDocument;

use Saxulum\JsonDocument\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributeNodeCreation()
    {
        $document = new Document();

        $attribute = $document->createAttributeNode('attribute');
        $attribute->setValue('attribute');

        $this->assertEquals('attribute', $attribute->getName());
        $this->assertEquals('@attribute', $attribute->getFormattedName());
        $this->assertEquals($document, $attribute->getDocument());
    }

    public function testValueNodeCreation()
    {
        $document = new Document();

        $value = $document->createValueNode('value');
        $value->setValue('value');

        $this->assertEquals('value', $value->getName());
        $this->assertEquals($document, $value->getDocument());
    }

    public function testObjectNodeCreation()
    {
        $document = new Document();

        $object = $document->createObjectNode('object');

        $this->assertEquals($document, $object->getDocument());
    }

    public function testObjectNodeAttributesCreation()
    {
        $document = new Document();

        $object = $document->createObjectNode('object');

        $attribute1 = $document->createAttributeNode('attribute1');
        $attribute1->setValue('attribute1');
        $object->addAttribute($attribute1);

        $attribute2 = $document->createAttributeNode('attribute2');
        $attribute2->setValue('attribute2');
        $object->addAttribute($attribute2);

        $attribute3 = $document->createAttributeNode('attribute3');
        $attribute3->setValue('attribute3');
        $object->addAttribute($attribute3);

        $this->assertCount(3, $object->getAttributes());
        
        $this->assertEquals($attribute1, $object->getAttribute('attribute1'));
        $this->assertEquals($attribute2, $object->getAttribute('attribute2'));
        $this->assertEquals($attribute3, $object->getAttribute('attribute3'));

        $this->assertEquals($object, $attribute1->getParent());
        $this->assertEquals($object, $attribute2->getParent());
        $this->assertEquals($object, $attribute3->getParent());

        $this->assertEquals(null, $attribute1->previousSibling());
        $this->assertEquals($attribute2, $attribute1->nextSibling());
        $this->assertEquals($attribute1, $attribute2->previousSibling());
        $this->assertEquals($attribute3, $attribute2->nextSibling());
        $this->assertEquals($attribute2, $attribute3->previousSibling());
        $this->assertEquals(null, $attribute3->nextSibling());
    }

    public function testObjectNodeNodesCreation()
    {
        $document = new Document();

        $object = $document->createObjectNode('object');

        $node1 = $document->createValueNode('node1');
        $node1->setValue('node1');
        $object->addNode($node1);

        $node2 = $document->createValueNode('node2');
        $node2->setValue('node2');
        $object->addNode($node2);

        $node3 = $document->createValueNode('node3');
        $node3->setValue('node3');
        $object->addNode($node3);

        $this->assertCount(3, $object->getNodes());

        $this->assertEquals($node1, $object->getNode('node1'));
        $this->assertEquals($node2, $object->getNode('node2'));
        $this->assertEquals($node3, $object->getNode('node3'));

        $this->assertEquals($object, $node1->getParent());
        $this->assertEquals($object, $node2->getParent());
        $this->assertEquals($object, $node3->getParent());

        $this->assertEquals(null, $node1->previousSibling());
        $this->assertEquals($node2, $node1->nextSibling());
        $this->assertEquals($node1, $node2->previousSibling());
        $this->assertEquals($node3, $node2->nextSibling());
        $this->assertEquals($node2, $node3->previousSibling());
        $this->assertEquals(null, $node3->nextSibling());
    }

    public function testArrayNodeCreation()
    {
        $document = new Document();

        $array = $document->createArrayNode('array');

        $this->assertEquals($document, $array->getDocument());
    }

    public function testArrayNodeNodesCreation()
    {
        $document = new Document();

        $array = $document->createArrayNode('array');

        $node1 = $document->createValueNode('node1');
        $node1->setValue('node1');
        $array->addNode($node1);

        $node2 = $document->createValueNode('node2');
        $node2->setValue('node2');
        $array->addNode($node2);

        $node3 = $document->createValueNode('node3');
        $node3->setValue('node3');
        $array->addNode($node3);

        $this->assertCount(3, $array->getNodes());

        $this->assertEquals($node1, $array->getNode(0));
        $this->assertEquals($node2, $array->getNode(1));
        $this->assertEquals($node3, $array->getNode(2));

        $this->assertEquals($array, $node1->getParent());
        $this->assertEquals($array, $node2->getParent());
        $this->assertEquals($array, $node3->getParent());

        $this->assertEquals(null, $node1->previousSibling());
        $this->assertEquals($node2, $node1->nextSibling());
        $this->assertEquals($node1, $node2->previousSibling());
        $this->assertEquals($node3, $node2->nextSibling());
        $this->assertEquals($node2, $node3->previousSibling());
        $this->assertEquals(null, $node3->nextSibling());
    }
}