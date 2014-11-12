<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\ArrayNode;
use Saxulum\JsonDocument\ValueNode;

class ArrayNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @return array
     */
    public function getArray(AbstractNode $node)
    {
        if (!$node instanceof ArrayNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        $array = array();

        foreach ($node->getNodes() as $index => $childNode) {
            if ($childNode instanceof ValueNode) {
                $array[$index] = $childNode->getValue();
            } else {
                $array[$index] = $this->getMainHandler()->getArray($childNode);
            }
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
