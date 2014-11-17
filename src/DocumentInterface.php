<?php

namespace Saxulum\JsonDocument;

interface DocumentInterface
{
    /**
     * @param  string        $name
     * @return AttributeNode
     */
    public function createAttributeNode($name);

    /**
     * @param  string    $name
     * @return ValueNode
     */
    public function createValueNode($name);

    /**
     * @param  string     $name
     * @return ObjectNode
     */
    public function createObjectNode($name);

    /**
     * @param  string    $name
     * @return ArrayNode
     */
    public function createArrayNode($name);

    /**
     * @param  AbstractNode $node
     * @param  int          $options
     * @param  \Closure     $filter
     * @return string
     * @throws \Exception
     */
    public function save(AbstractNode $node = null, $options = 0, \Closure $filter = null);

    /**
     * @return AbstractElement[]
     */
    public function getNodes();

    /**
     * @param  int|string           $index node name or index, depends on object or array
     * @return AbstractElement|null
     */
    public function getNode($index);

    /**
     * @param  AbstractElement $node
     * @return void
     */
    public function addNode(AbstractElement $node);

    /**
     * @param  AbstractElement $node
     * @return void
     */
    public function removeNode(AbstractElement $node);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return DocumentInterface
     */
    public function getDocument();

    /**
     * @return AbstractParent|null
     */
    public function getParent();

    /**
     * @return AbstractNode|null
     */
    public function previousSibling();

    /**
     * @return AbstractNode|null
     */
    public function nextSibling();
}
