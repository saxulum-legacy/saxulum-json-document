<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\ValueNode;

class ValueNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @param  bool         $embedded
     * @return array
     */
    public function getArray(AbstractNode $node, $embedded = false)
    {
        if (!$node instanceof ValueNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        if (!$embedded) {
            return array($node->getName() => $node->getValue());
        }

        return $node->getValue();
    }

    /**
     * @param  AbstractNode $node
     * @return bool
     */
    public function isResponsible(AbstractNode $node)
    {
        return $node instanceof ValueNode;
    }
}
