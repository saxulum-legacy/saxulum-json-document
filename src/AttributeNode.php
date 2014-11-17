<?php

namespace Saxulum\JsonDocument;

class AttributeNode extends AbstractNode
{
    /**
     * @var null|string|int|float|bool
     */
    protected $value;

    /**
     * @var ObjectNode
     */
    protected $parent;

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
        if (null === $parent = $this->parent) {
            return null;
        }

        return $this->getSibling($parent->getAttributes(), 1);
    }
}
