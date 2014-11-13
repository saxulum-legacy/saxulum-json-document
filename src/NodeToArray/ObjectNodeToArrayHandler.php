<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;
use Saxulum\JsonDocument\ObjectNode;

class ObjectNodeToArrayHandler extends AbstractNodeToArrayHandler
{
    /**
     * @param  AbstractNode $node
     * @param  bool         $embedded
     * @return array
     */
    public function getArray(AbstractNode $node, $embedded = false)
    {
        if (!$node instanceof ObjectNode) {
            throw new \InvalidArgumentException("Invalid node type!");
        }

        $array = array();

        foreach ($node->getAttributes() as $attribute) {
            $array[$attribute->getFormattedName()] =$this->getMainHandler()->getArray($attribute, true);
        }

        foreach ($node->getNodes() as $name => $childNode) {
            $array[$name] = $this->getMainHandler()->getArray($childNode, true);
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
