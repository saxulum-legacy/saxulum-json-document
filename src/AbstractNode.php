<?php

namespace Saxulum\JsonDocument;

abstract class AbstractNode
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var DocumentInterface
     */
    protected $document;

    /**
     * @var null|AbstractParent
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
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return null|AbstractParent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return null|AbstractNode
     */
    abstract public function previousSibling();

    /**
     * @return null|AbstractNode
     */
    abstract public function nextSibling();

    /**
     * @param  AbstractNode[]     $nodes
     * @param  int                $rel
     * @return null|AbstractNode
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
}
