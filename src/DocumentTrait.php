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

        Document::setProperty($attribute, 'name', $name);
        Document::setProperty($attribute, 'document', $this);

        return $attribute;
    }

    /**
     * @param  string    $name
     * @return ValueNode
     */
    public function createValueNode($name)
    {
        $value = new ValueNode();

        Document::setProperty($value, 'name', $name);
        Document::setProperty($value, 'document', $this);

        return $value;
    }

    /**
     * @param  string     $name
     * @return ObjectNode
     */
    public function createObjectNode($name)
    {
        $object = new ObjectNode();

        Document::setProperty($object, 'name', $name);
        Document::setProperty($object, 'document', $this);

        return $object;
    }

    /**
     * @param  string    $name
     * @return ArrayNode
     */
    public function createArrayNode($name)
    {
        $array = new ArrayNode();

        Document::setProperty($array, 'name', $name);
        Document::setProperty($array, 'document', $this);

        return $array;
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
