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

    /**
     * @param object $object
     * @param string $property
     * @param mixed  $value
     */
    public static function setProperty($object, $property, $value)
    {
        static $reflection;

        if (null === $reflection) {
            $reflection = new \ReflectionClass('Saxulum\JsonDocument\AbstractNode');
        }

        $pRef = $reflection->getProperty($property);
        $pRef->setAccessible(true);
        $pRef->setValue($object, $value);
        $pRef->setAccessible(false);
    }
}
