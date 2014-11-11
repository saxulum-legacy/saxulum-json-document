<?php

namespace Saxulum\JsonDocument;

class Document extends AbstractNode
{
    /**
     * @var AbstractParent $node
     */
    protected $node;

    protected function __construct() {}

    /**
     * @return Document
     */
    public static function newByObjectNode()
    {
        $instance = new self();
        $instance->node = $instance->createObjectNode('__document__');

        return $instance;
    }

    /**
     * @return Document
     */
    public static function newByArrayNode()
    {
        $instance = new self();
        $instance->node = $instance->createArrayNode('__document__');

        return $instance;
    }

    /**
     * @return ObjectNode|ArrayNode
     */
    public function getMainNode()
    {
        return $this->node;
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
     * @param \ReflectionClass $ref
     * @param object           $object
     * @param string           $property
     * @param mixed            $value
     */
    public function setProperty(\ReflectionClass $ref, $object, $property, $value)
    {
        $pRef = $ref->getProperty($property);
        $pRef->setAccessible(true);
        $pRef->setValue($object, $value);
        $pRef->setAccessible(false);
    }

    /**
     * @return $this
     */
    public function getDocument()
    {
        return $this;
    }

    /**
     * @return AbstractNode|null
     */
    public function previousSibling()
    {
        /** @var AbstractParent $parent */
        if (null === $node = $this->node) {
            return null;
        }

        return $this->getSibling($node->getNodes(), -1);
    }

    /**
     * @return AbstractNode|null
     */
    public function nextSibling()
    {
        /** @var AbstractParent $parent */
        if (null === $node = $this->node) {
            return null;
        }

        return $this->getSibling($node->getNodes(), 1);
    }

    /**
     * @param  AbstractNode $node
     * @param  int          $options
     * @param  callable     $filter
     * @return string
     * @throws \Exception
     */
    public function save(AbstractNode $node = null, $options = 0, \Closure $filter = null)
    {
        if (null === $node) {
            if (null === $this->node) {
                throw new \Exception("There is no main node on this document!");
            }

            $node = $this->node;
        }

        $array = $this->getArray($node);

        if (null !== $filter) {
            $array = $this->walkRecursiveRemove($array, $filter);
        }

        return json_encode($array, $options);
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

    /**
     * @source https://github.com/gajus/marray/blob/master/src/marray.php
     * @copyright Copyright (c) 2013-2014, Anuary (http://anuary.com/)
     * @param  array    $array
     * @param  callable $callback
     * @return array
     */
    protected function walkRecursiveRemove(array $array, callable $callback)
    {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                $array[$k] = $this->walkRecursiveRemove($v, $callback);
            } else {
                if ($callback($v, $k)) {
                    unset($array[$k]);
                }
            }
        }

        return $array;
    }
}
