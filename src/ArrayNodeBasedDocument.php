<?php

namespace Saxulum\JsonDocument;

class ArrayNodeBasedDocument extends ArrayNode
{
    use DocumentTrait;

    public function __construct()
    {
        $this->document = $this;
    }
}
