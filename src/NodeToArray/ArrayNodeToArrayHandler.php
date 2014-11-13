<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\ArrayNode;

class ArrayNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @param  bool         $embedded
     * @return array
     */
    public function getArray(AbstractNode $node, $embedded = false)
    {
        if (!$node instanceof ArrayNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        $array = array();

        foreach ($node->getNodes() as $index => $childNode) {
            $array[$index] = $this->getMainHandler()->getArray($childNode, true);
        }

        return $array;
    }

    /**
     * @param  AbstractNode $node
     * @return bool
     */
    public function isResponsible(AbstractNode $node)
    {
        return $node instanceof ArrayNode;
    }
}
