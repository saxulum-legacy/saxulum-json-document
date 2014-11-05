<?php

namespace Saxulum\JsonDocument;

abstract class AbstractParent extends AbstractElement
{
    /**
     * @var \ReflectionClass
     */
    protected $rAbstractNode;

    /**
     * @var \ReflectionClass
     */
    protected $rAttributeNode;

    /**
     * @var \ReflectionClass
     */
    protected $rValueNode;

    /**
     * @var \ReflectionClass
     */
    protected $rObjectNode;

    /**
     * @var \ReflectionClass
     */
    protected $rArrayNode;

    /**
     * @var AbstractElement[]
     */
    protected $nodes = array();

    /**
     * @return AbstractElement[]
     */
    public function getNodes()
    {
        return $this->nodes;
    }

    /**
     * @param AbstractElement $node
     */
    abstract public function addNode(AbstractElement $node);

    /**
     * @param AbstractElement $node
     */
    abstract public function removeNode(AbstractElement $node);

    /**
     * @param  int|string           $index node name or index, depends on object or array
     * @return AbstractElement|null
     */
    public function getNode($index)
    {
        return isset($this->nodes[$index]) ? $this->nodes[$index] : null;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getAbstractNodeReflection()
    {
        if (null === $this->rAbstractNode) {
            $this->rAbstractNode = new \ReflectionClass('Saxulum\JsonDocument\AbstractNode');
        }

        return $this->rAbstractNode;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getAttributeNodeReflection()
    {
        if (null === $this->rAttributeNode) {
            $this->rAttributeNode = new \ReflectionClass('Saxulum\JsonDocument\AttributeNode');
        }

        return $this->rAttributeNode;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getValueNodeReflection()
    {
        if (null === $this->rValueNode) {
            $this->rValueNode = new \ReflectionClass('Saxulum\JsonDocument\ValueNode');
        }

        return $this->rValueNode;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getObjectNodeReflection()
    {
        if (null === $this->rObjectNode) {
            $this->rObjectNode = new \ReflectionClass('Saxulum\JsonDocument\ObjectNode');
        }

        return $this->rObjectNode;
    }

    /**
     * @return \ReflectionClass
     */
    protected function getArrayNodeReflection()
    {
        if (null === $this->rArrayNode) {
            $this->rArrayNode = new \ReflectionClass('Saxulum\JsonDocument\ArrayNode');
        }

        return $this->rArrayNode;
    }

    /**
     * @param \ReflectionClass $ref
     * @param object           $object
     * @param string           $property
     * @param mixed            $value
     */
    protected function setProperty(\ReflectionClass $ref, $object, $property, $value)
    {
        $pRef = $ref->getProperty($property);
        $pRef->setAccessible(true);
        $pRef->setValue($object, $value);
        $pRef->setAccessible(false);
    }

    /**
     * @param  AbstractNode $node
     * @throws \Exception
     */
    protected function checkNode(AbstractNode $node)
    {
        if (null === $node->getName()) {
            throw new \Exception("Use the create<nodetype>Node on document!");
        }

        if (null === $node->getDocument() || $this->getDocument() !== $node->getDocument()) {
            throw new \Exception("Use the create<nodetype>Node on document!");
        }
    }
}
