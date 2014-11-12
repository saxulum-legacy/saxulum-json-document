<?php

namespace Saxulum\JsonDocument;

class ObjectNodeBasedDocument extends ObjectNode
{
    use DocumentTrait;

    public function __construct()
    {
        $this->document = $this;
    }
}
