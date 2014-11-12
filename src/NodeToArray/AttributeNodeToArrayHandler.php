<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\AttributeNode;

class AttributeNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @return array
     */
    public function getArray(AbstractNode $node)
    {
        if (!$node instanceof AttributeNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        return array($node->getFormattedName() => $node->getValue());
    }

    /**
     * @param  AbstractNode $node
     * @return bool
     */
    public function isResponsible(AbstractNode $node)
    {
        return $node instanceof AttributeNode;
    }
}
