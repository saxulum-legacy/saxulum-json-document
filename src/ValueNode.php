<?php

namespace Saxulum\JsonDocument;

class ValueNode extends AbstractElement
{
    /**
     * @var null|string|int|float|bool
     */
    protected $value;

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
}
