<?php

namespace Saxulum\JsonDocument;

abstract class AbstractParent extends AbstractElement
{
    /**
     * @var AbstractElement[]
     */
    protected $nodes = array();

    /**
     * @return AbstractElement[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param  int|string           $index node name or index, depends on object or array
     * @return AbstractElement|null
     */
    public function getNode($index)
    {
        return isset($this->nodes[$index]) ? $this->nodes[$index] : null;
    }

    /**
     * @param AbstractElement $node
     */
    abstract public function addNode(AbstractElement $node);

    /**
     * @param AbstractElement $node
     */
    abstract public function removeNode(AbstractElement $node);

    /**
     * @param  AbstractElement $node
     * @throws \Exception
     */
    protected function checkNode(AbstractElement $node)
    {
        if (null === $node->getName()) {
            throw new \Exception("Use the create<nodetype>Node on document!");
        }

        if (null === $node->getDocument() || $this->getDocument() !== $node->getDocument()) {
            throw new \Exception("Use the create<nodetype>Node on document!");
        }
    }

    /**
     * @param AbstractElement $node
     */
    protected function removeNodeFromParent(AbstractElement $node)
    {
        if (null !== $parent = $node->getParent()) {
            $parent->removeNode($node);
        }
    }
}
