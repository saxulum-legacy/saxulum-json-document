<?php

namespace Saxulum\JsonDocument;

class ObjectNode extends AbstractParent
{
    /**
     * @var AttributeNode[]
     */
    protected $attributes;

    /**
     * @param AttributeNode $attribute
     */
    public function addAttribute(AttributeNode $attribute)
    {
        $name = $attribute->getName();
        if(isset($this->attributes[$name])) {
            throw new \InvalidArgumentException("There is allready a attribute with this name!");
        }

        $this->checkNode($attribute);
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $attribute, 'parent', $this);
        $this->attributes[$attribute->getName()] = $attribute;
    }

    /**
     * @param AttributeNode $attribute
     * @throw \InvalidArgumentException
     */
    public function removeAttribute(AttributeNode $attribute)
    {
        $name = $attribute->getName();
        if(!isset($this->attributes[$name])) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $attribute, 'parent', null);
    }

    /**
     * @return AttributeNode[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $name
     * @return AttributeNode|null
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param AbstractElement $child
     */
    public function addChild(AbstractElement $child)
    {
        $name = $child->getName();
        if(isset($this->childs[$name])) {
            throw new \InvalidArgumentException("There is allready a node with this name!");
        }

        $this->checkNode($child);
        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $child, 'parent', $this);
        $this->childs[$child->getName()] = $child;
    }

    /**
     * @param AbstractElement $child
     */
    public function removeChild(AbstractElement $child)
    {
        $name = $child->getName();
        if(!isset($this->childs[$name])) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        $ref = $this->getAbstractNodeReflection();
        $this->setProperty($ref, $child, 'parent', null);
    }
}