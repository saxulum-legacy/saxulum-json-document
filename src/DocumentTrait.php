<?php

namespace Saxulum\JsonDocument;

use Saxulum\JsonDocument\NodeToArray\ArrayNodeToArrayHandler;
use Saxulum\JsonDocument\NodeToArray\AttributeNodeToArrayHandler;
use Saxulum\JsonDocument\NodeToArray\NodeToArray;
use Saxulum\JsonDocument\NodeToArray\ObjectNodeToArrayHandler;
use Saxulum\JsonDocument\NodeToArray\ValueNodeToArrayHandler;

trait DocumentTrait
{
    /**
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * @var NodeToArray
     */
    protected $nodeToArrayHandler;

    /**
     * @param  string        $name
     * @return AttributeNode
     */
    public function createAttributeNode($name)
    {
        $attribute = new AttributeNode();

        $this->setProperty($attribute, 'name', $name);
        $this->setProperty($attribute, 'document', $this);

        return $attribute;
    }

    /**
     * @param  string    $name
     * @return ValueNode
     */
    public function createValueNode($name)
    {
        $value = new ValueNode();

        $this->setProperty($value, 'name', $name);
        $this->setProperty($value, 'document', $this);

        return $value;
    }

    /**
     * @param  string     $name
     * @return ObjectNode
     */
    public function createObjectNode($name)
    {
        $object = new ObjectNode();

        $this->setProperty($object, 'name', $name);
        $this->setProperty($object, 'document', $this);

        return $object;
    }

    /**
     * @param  string    $name
     * @return ArrayNode
     */
    public function createArrayNode($name)
    {
        $array = new ArrayNode();

        $this->setProperty($array, 'name', $name);
        $this->setProperty($array, 'document', $this);

        return $array;
    }

    /**
     * @param object $object
     * @param string $property
     * @param mixed  $value
     */
    public function setProperty($object, $property, $value)
    {
        if (null === $this->reflection) {
            $this->reflection = new \ReflectionClass('Saxulum\JsonDocument\AbstractNode');
        }

        $pRef = $this->reflection->getProperty($property);
        $pRef->setAccessible(true);
        $pRef->setValue($object, $value);
        $pRef->setAccessible(false);
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
            $node = $this;
        }

        $array = $this->getNodeToArrayHandler()->getArray($node);

        if (null !== $filter) {
            $array = $this->walkRecursiveRemove($array, $filter);
        }

        return json_encode($array, $options);
    }

    /**
     * @return NodeToArray
     */
    public function getNodeToArrayHandler()
    {
        if (null === $this->nodeToArrayHandler) {
            $this->nodeToArrayHandler = new NodeToArray(array(
                new ObjectNodeToArrayHandler(),
                new ArrayNodeToArrayHandler(),
                new AttributeNodeToArrayHandler(),
                new ValueNodeToArrayHandler()
            ));
        }

        return $this->nodeToArrayHandler;
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
