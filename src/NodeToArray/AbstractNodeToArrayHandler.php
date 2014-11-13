<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;

abstract class AbstractNodeToArrayHandler
{
    /**
     * @var NodeToArray
     */
    protected $mainHandler;

    /**
     * @param  NodeToArray $mainHandler
     * @return void
     */
    public function setMainHandler(NodeToArray $mainHandler)
    {
        $this->mainHandler = $mainHandler;
    }

    /**
     * @return NodeToArray
     * @throws \Exception
     */
    public function getMainHandler()
    {
        if (null === $this->mainHandler) {
            throw new \Exception("This handler can't work without the main handler!");
        }

        return $this->mainHandler;
    }

    /**
     * @param  AbstractNode $node
     * @param  bool         $embedded
     * @return array
     */
    abstract public function getArray(AbstractNode $node, $embedded = false);

    /**
     * @param  AbstractNode $node
     * @return bool
     */
    abstract public function isResponsible(AbstractNode $node);
}
