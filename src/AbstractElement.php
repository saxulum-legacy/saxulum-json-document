<?php

namespace Saxulum\JsonDocument;

abstract class AbstractElement extends AbstractNode
{
    /**
     * @return AttributeNode|null
     */
    public function previousSibling()
    {
        /** @var AbstractParent $parent */
        if(null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getNodes(), -1);
    }

    /**
     * @return AttributeNode|null
     */
    public function nextSibling()
    {
        /** @var AbstractParent $parent */
        if(null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getNodes(), 1);
    }
}