<?php

namespace Saxulum\JsonDocument;

abstract class AbstractElement extends AbstractNode
{
    /**
     * @return null|AbstractNode
     */
    public function previousSibling()
    {
        if (null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getNodes(), -1);
    }

    /**
     * @return null|AbstractNode
     */
    public function nextSibling()
    {
        if (null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getNodes(), 1);
    }
}
