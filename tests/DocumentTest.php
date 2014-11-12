<?php

namespace Saxulum\Tests\JsonDocument;

use Saxulum\JsonDocument\Document;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testAttributeNodeCreation()
    {
        $document = Document::createObjectNodeBased();

        $attribute = $document->createAttributeNode('attribute');
        $attribute->setValue('attribute');

        $this->assertEquals('attribute', $attribute->getName());
        $this->assertEquals('@attribute', $attribute->getFormattedName());
        $this->assertEquals($document, $attribute->getDocument());
    }

    public function testValueNodeCreation()
    {
        $document = Document::createObjectNodeBased();

        $value = $document->createValueNode('value');
        $value->setValue('value');

        $this->assertEquals('value', $value->getName());
        $this->assertEquals($document, $value->getDocument());
    }

    public function testObjectNodeCreation()
    {
        $document = Document::createObjectNodeBased();

        $object = $document->createObjectNode('object');

        $this->assertEquals($document, $object->getDocument());
    }

    public function testObjectNodeAttributesCreation()
    {
        $document = Document::createObjectNodeBased();

        $attribute1 = $document->createAttributeNode('attribute1');
        $attribute1->setValue('attribute1');
        $document->addAttribute($attribute1);

        $attribute2 = $document->createAttributeNode('attribute2');
        $attribute2->setValue('attribute2');
        $document->addAttribute($attribute2);

        $attribute3 = $document->createAttributeNode('attribute3');
        $attribute3->setValue('attribute3');
        $document->addAttribute($attribute3);

        $this->assertCount(3, $document->getAttributes());

        $this->assertEquals($attribute1, $document->getAttribute('attribute1'));
        $this->assertEquals($attribute2, $document->getAttribute('attribute2'));
        $this->assertEquals($attribute3, $document->getAttribute('attribute3'));

        $this->assertEquals($document, $attribute1->getParent());
        $this->assertEquals($document, $attribute2->getParent());
        $this->assertEquals($document, $attribute3->getParent());

        $this->assertEquals(null, $attribute1->previousSibling());
        $this->assertEquals($attribute2, $attribute1->nextSibling());
        $this->assertEquals($attribute1, $attribute2->previousSibling());
        $this->assertEquals($attribute3, $attribute2->nextSibling());
        $this->assertEquals($attribute2, $attribute3->previousSibling());
        $this->assertEquals(null, $attribute3->nextSibling());
    }

    public function testObjectNodeNodesCreation()
    {
        $document = Document::createObjectNodeBased();

        $node1 = $document->createValueNode('node1');
        $node1->setValue('node1');
        $document->addNode($node1);

        $node2 = $document->createValueNode('node2');
        $node2->setValue('node2');
        $document->addNode($node2);

        $node3 = $document->createValueNode('node3');
        $node3->setValue('node3');
        $document->addNode($node3);

        $this->assertCount(3, $document->getNodes());

        $this->assertEquals($node1, $document->getNode('node1'));
        $this->assertEquals($node2, $document->getNode('node2'));
        $this->assertEquals($node3, $document->getNode('node3'));

        $this->assertEquals($document, $node1->getParent());
        $this->assertEquals($document, $node2->getParent());
        $this->assertEquals($document, $node3->getParent());

        $this->assertEquals(null, $node1->previousSibling());
        $this->assertEquals($node2, $node1->nextSibling());
        $this->assertEquals($node1, $node2->previousSibling());
        $this->assertEquals($node3, $node2->nextSibling());
        $this->assertEquals($node2, $node3->previousSibling());
        $this->assertEquals(null, $node3->nextSibling());
    }

    public function testArrayNodeCreation()
    {
        $document = Document::createObjectNodeBased();

        $array = $document->createArrayNode('array');

        $this->assertEquals($document, $array->getDocument());
    }

    public function testArrayNodeNodesCreation()
    {
        $document = Document::createArrayNodeBased();

        $node1 = $document->createValueNode('node1');
        $node1->setValue('node1');
        $document->addNode($node1);

        $node2 = $document->createValueNode('node2');
        $node2->setValue('node2');
        $document->addNode($node2);

        $node3 = $document->createValueNode('node3');
        $node3->setValue('node3');
        $document->addNode($node3);

        $this->assertCount(3, $document->getNodes());

        $this->assertEquals($node1, $document->getNode(0));
        $this->assertEquals($node2, $document->getNode(1));
        $this->assertEquals($node3, $document->getNode(2));

        $this->assertEquals($document, $node1->getParent());
        $this->assertEquals($document, $node2->getParent());
        $this->assertEquals($document, $node3->getParent());

        $this->assertEquals(null, $node1->previousSibling());
        $this->assertEquals($node2, $node1->nextSibling());
        $this->assertEquals($node1, $node2->previousSibling());
        $this->assertEquals($node3, $node2->nextSibling());
        $this->assertEquals($node2, $node3->previousSibling());
        $this->assertEquals(null, $node3->nextSibling());
    }

    public function testSave()
    {
        $document = Document::createObjectNodeBased();

        $object = $document->createObjectNode('object');
        $document->addNode($object);

        $attribute1 = $document->createAttributeNode('attribute1');
        $attribute1->setValue('attribute1');
        $object->addAttribute($attribute1);

        $attribute2 = $document->createAttributeNode('attribute2');
        $attribute2->setValue('attribute2');
        $object->addAttribute($attribute2);

        $attribute3 = $document->createAttributeNode('attribute3');
        $attribute3->setValue('attribute3');
        $object->addAttribute($attribute3);

        $node1 = $document->createValueNode('node1');
        $node1->setValue('node1');
        $object->addNode($node1);

        $node2 = $document->createValueNode('node2');
        $node2->setValue('node2');
        $object->addNode($node2);

        $node3 = $document->createValueNode('node3');
        $node3->setValue('node3');
        $object->addNode($node3);

        $object1 = $document->createObjectNode('object');
        $object->addNode($object1);

        $node11 = $document->createValueNode('node1');
        $node11->setValue('node1');
        $object1->addNode($node11);

        $node12 = $document->createValueNode('node2');
        $node12->setValue('node2');
        $object1->addNode($node12);

        $node13 = $document->createValueNode('node3');
        $node13->setValue('node3');
        $object1->addNode($node13);

        $array1 = $document->createArrayNode('array');
        $object->addNode($array1);

        $object2 = $document->createObjectNode('object');
        $array1->addNode($object2);

        $node21 = $document->createValueNode('node1');
        $node21->setValue('node1');
        $object2->addNode($node21);

        $node22 = $document->createValueNode('node2');
        $node22->setValue('node2');
        $object2->addNode($node22);

        $node23 = $document->createValueNode('node3');
        $node23->setValue('node3');
        $object2->addNode($node23);

        $json = $document->save();

        $this->assertEquals('{"object":{"@attribute1":"attribute1","@attribute2":"attribute2","@attribute3":"attribute3","node1":"node1","node2":"node2","node3":"node3","object":{"node1":"node1","node2":"node2","node3":"node3"},"array":[{"node1":"node1","node2":"node2","node3":"node3"}]}}', $json);
    }
}
