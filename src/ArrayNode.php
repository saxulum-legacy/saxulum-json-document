<?php

namespace Saxulum\JsonDocument;

class ArrayNode extends AbstractParent
{
    /**
     * @param AbstractElement $node
     */
    public function addNode(AbstractElement $node)
    {
        if (in_array($node, $this->nodes, true)) {
            throw new \InvalidArgumentException("You can't add the same node twice!");
        }

        $this->checkNode($node);
        $this->getDocument()->setProperty($node, 'parent', $this);
        $this->nodes[] = $node;
    }

    /**
     * @param AbstractElement $node
     */
    public function removeNode(AbstractElement $node)
    {
        if (false !== $index = array_search($node, $this->nodes, true)) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        $this->getDocument()->setProperty($node, 'parent', null);
    }
}
