<?php

namespace Saxulum\JsonDocument;

class ArrayNode extends AbstractParent
{
    /**
     * @param AbstractElement $child
     */
    public function addChild(AbstractElement $child)
    {
        if(in_array($child, $this->childs, true)) {
            throw new \InvalidArgumentException("You can't add the same node twice!");
        }

        $this->checkNode($child);
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $child, 'parent', $this);
        $this->childs[] = $child;
    }

    /**
     * @param AbstractElement $child
     */
    public function removeChild(AbstractElement $child)
    {
        if(false !== $index = array_search($child, $this->childs, true)) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $child, 'parent', null);
    }
}