<?php

namespace Saxulum\JsonDocument;

class ObjectNodeBasedDocument extends ObjectNode implements DocumentInterface
{
    use DocumentTrait;

    protected $name = 'document';

    public function __construct()
    {
        $this->document = $this;
    }
}
