<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\ObjectNode;
use Saxulum\JsonDocument\ValueNode;

class ObjectNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @return array
     */
    public function getArray(AbstractNode $node)
    {
        if (!$node instanceof ObjectNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        $array = array();

        foreach ($node->getAttributes() as $attribute) {
            $array[$attribute->getFormattedName()] = $attribute->getValue();
        }

        foreach ($node->getNodes() as $name => $childNode) {
            if ($childNode instanceof ValueNode) {
                $array[$name] = $childNode->getValue();
            } else {
                $array[$name] = $this->getMainHandler()->getArray($childNode);
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
        return $node instanceof ObjectNode;
    }
}
