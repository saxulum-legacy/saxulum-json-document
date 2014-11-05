<?php

namespace Saxulum\JsonDocument;


class Document extends ObjectNode
{
    public function __construct()
    {
        $this->document = $this;
    }

    /**
     * @param string $name
     * @return AttributeNode
     */
    public function createAttributeNode($name)
    {
        $ref = $this->getAttributeNodeReflection();
        $attribute = $ref->newInstanceWithoutConstructor();
        $this->setProperty($ref, $attribute, 'name', $name);
        $this->setProperty($ref, $attribute, 'document', $this);

        return $attribute;
    }

    /**
     * @param string $name
     * @return ValueNode
     */
    public function createValueNode($name)
    {
        $ref = $this->getValueNodeReflection();
        $value = $ref->newInstanceWithoutConstructor();
        $this->setProperty($ref, $value, 'name', $name);
        $this->setProperty($ref, $value, 'document', $this);

        return $value;
    }

    /**
     * @param string $name
     * @return ObjectNode
     */
    public function createObjectNode($name)
    {
        $ref = $this->getObjectNodeReflection();
        $object = $ref->newInstanceWithoutConstructor();
        $this->setProperty($ref, $object, 'name', $name);
        $this->setProperty($ref, $object, 'document', $this);

        return $object;
    }

    /**
     * @param string $name
     * @return ArrayNode
     */
    public function createArrayNode($name)
    {
        $ref = $this->getArrayNodeReflection();
        $array = $ref->newInstanceWithoutConstructor();
        $this->setProperty($ref, $array, 'name', $name);
        $this->setProperty($ref, $array, 'document', $this);

        return $array;
    }
}