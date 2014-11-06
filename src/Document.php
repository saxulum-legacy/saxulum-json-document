<?php

namespace Saxulum\JsonDocument;

class Document extends ObjectNode
{
    public function __construct()
    {
        $this->document = $this;
    }

    /**
     * @param  string        $name
     * @return AttributeNode
     */
    public function createAttributeNode($name)
    {
        $attribute = new AttributeNode();
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $attribute, 'name', $name);
        $this->setProperty($ref, $attribute, 'document', $this);

        return $attribute;
    }

    /**
     * @param  string    $name
     * @return ValueNode
     */
    public function createValueNode($name)
    {
        $value = new ValueNode();
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $value, 'name', $name);
        $this->setProperty($ref, $value, 'document', $this);

        return $value;
    }

    /**
     * @param  string     $name
     * @return ObjectNode
     */
    public function createObjectNode($name)
    {
        $object = new ObjectNode();
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $object, 'name', $name);
        $this->setProperty($ref, $object, 'document', $this);

        return $object;
    }

    /**
     * @param  string    $name
     * @return ArrayNode
     */
    public function createArrayNode($name)
    {
        $array = new ArrayNode();
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $array, 'name', $name);
        $this->setProperty($ref, $array, 'document', $this);

        return $array;
    }

    /**
     * @param  AbstractNode $node
     * @param  int          $options
     * @return string
     */
    public function save(AbstractNode $node = null, $options = 0)
    {
        if (null === $node) {
            $node = $this;
        }

        return json_encode($this->getArray($node), $options);
    }

    /**
     * @param  AbstractNode $node
     * @return array
     */
    protected function getArray(AbstractNode $node)
    {
        if ($node instanceof AttributeNode) {
            return $this->getArrayFromAttributeNode($node);
        } elseif ($node instanceof ValueNode) {
            return $this->getArrayFromValueNode($node);
        } elseif ($node instanceof ObjectNode) {
            return $this->getArrayFromObjectNode($node);
        } elseif ($node instanceof ArrayNode) {
            return $this->getArrayFromArrayNode($node);
        }

        throw new \InvalidArgumentException("There is no logic for this node type!");
    }

    /**
     * @param  AttributeNode $node
     * @return array
     */
    protected function getArrayFromAttributeNode(AttributeNode $node)
    {
        return array($node->getFormattedName() => $node->getValue());
    }

    /**
     * @param  ValueNode $node
     * @return array
     */
    protected function getArrayFromValueNode(ValueNode $node)
    {
        return array($node->getName() => $node->getValue());
    }

    /**
     * @param  ObjectNode $node
     * @return array
     */
    protected function getArrayFromObjectNode(ObjectNode $node)
    {
        $array = array();

        foreach ($node->getAttributes() as $attribute) {
            $array[$attribute->getFormattedName()] = $attribute->getValue();
        }

        foreach ($node->getNodes() as $name => $childNode) {
            if ($childNode instanceof ValueNode) {
                $array[$name] = $childNode->getValue();
            } else {
                $array[$name] = $this->getArray($childNode);
            }
        }

        return $array;
    }

    /**
     * @param  ArrayNode $node
     * @return array
     */
    protected function getArrayFromArrayNode(ArrayNode $node)
    {
        $array = array();

        foreach ($node->getNodes() as $index => $childNode) {
            if ($childNode instanceof ValueNode) {
                $array[$index] = $childNode->getValue();
            } else {
                $array[$index] = $this->getArray($childNode);
            }
        }

        return $array;
    }
}
