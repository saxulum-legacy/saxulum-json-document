<?php

namespace Saxulum\JsonDocument;

class AttributeNode extends AbstractNode
{
    /**
     * @var null|string|int|float|bool
     */
    protected $value;

    /**
     * @return string
     */
    public function getName()
    {
        if('@' !== substr($this->name, 0, 1)) {
            return '@' . $this->name;
        }

        return $this->name;
    }

    /**
     * @return bool|float|int|null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param bool|float|int|null|string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return AttributeNode|null
     */
    public function previousSibling()
    {
        /** @var ObjectNode $parent */
        if(null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getAttributes(), -1);
    }

    /**
     * @return AttributeNode|null
     */
    public function nextSibling()
    {
        /** @var ObjectNode $parent */
        if(null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getAttributes(), 1);
    }
}