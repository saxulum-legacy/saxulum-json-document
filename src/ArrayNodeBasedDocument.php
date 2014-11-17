<?php

namespace Saxulum\JsonDocument;

class ArrayNodeBasedDocument extends ArrayNode implements DocumentInterface
{
    use DocumentTrait;

    protected $name = 'document';

    public function __construct()
    {
        $this->document = $this;
    }
}
