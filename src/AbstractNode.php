<?php

namespace Saxulum\JsonDocument;

abstract class AbstractNode
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Document
     */
    protected $document;

    /**
     * @var AbstractParent
     */
    protected $parent;

    /**
     * @var \ReflectionClass
     */
    protected $rAbstractNode;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return AbstractParent|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return AbstractNode|null
     */
    abstract public function previousSibling();

    /**
     * @return AbstractNode|null
     */
    abstract public function nextSibling();

    /**
     * @param  AbstractNode[]     $nodes
     * @param  int                $rel
     * @return null|AttributeNode
     */
    protected function getSibling(array $nodes, $rel)
    {
        $nodeKeys = array_keys($nodes);
        $nodeKey = array_search($this, $nodes, true);
        $nodeIndex = array_search($nodeKey, $nodeKeys, true);
        $prevNodeIndex = $nodeIndex + $rel;

        if (!isset($nodeKeys[$prevNodeIndex])) {
            return null;
        }

        $prevNodeIndex = $nodeKeys[$prevNodeIndex];

        return $nodes[$prevNodeIndex];
    }

    /**
     * @return \ReflectionClass
     */
    protected function getAbstractNodeReflection()
    {
        if (null === $this->rAbstractNode) {
            $this->rAbstractNode = new \ReflectionClass(__CLASS__);
        }

        return $this->rAbstractNode;
    }

    /**
     * @param \ReflectionClass $ref
     * @param object           $object
     * @param string           $property
     * @param mixed            $value
     */
    protected function setProperty(\ReflectionClass $ref, $object, $property, $value)
    {
        $pRef = $ref->getProperty($property);
        $pRef->setAccessible(true);
        $pRef->setValue($object, $value);
        $pRef->setAccessible(false);
    }
}
