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
    public function getFormattedName()
    {
        return '@' . $this->name;
    }

    /**
     * @return bool|float|int|null|string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  bool|float|int|null|string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return null|AttributeNode
     */
    public function previousSibling()
    {
        /** @var ObjectNode $parent */
        if (null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getAttributes(), -1);
    }

    /**
     * @return null|AttributeNode
     */
    public function nextSibling()
    {
        /** @var ObjectNode $parent */
        if (null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getAttributes(), 1);
    }
}
