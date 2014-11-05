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
     * @param AbstractNode[] $nodes
     * @param int $rel
     * @return null|AttributeNode
     */
    protected function getSibling(array $nodes, $rel)
    {
        $nodeKeys = array_keys($nodes);
        $nodeKey = array_search($this, $nodes, true);
        $nodeIndex = array_search($nodeKey, $nodeKeys, true);
        $prevNodeIndex = $nodeIndex + $rel;

        if(!isset($nodeKeys[$prevNodeIndex])) {
            return null;
        }

        $prevNodeIndex = $nodeKeys[$prevNodeIndex];

        return $nodes[$prevNodeIndex];
    }
}