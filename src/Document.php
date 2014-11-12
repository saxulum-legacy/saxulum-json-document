<?php

namespace Saxulum\JsonDocument;

class Document
{
    /**
     * @return ObjectNodeBasedDocument
     */
    public static function createObjectNodeBased()
    {
        return new ObjectNodeBasedDocument();
    }

    /**
     * @return ArrayNodeBasedDocument
     */
    public static function createArrayNodeBased()
    {
        return new ArrayNodeBasedDocument();
    }
}
