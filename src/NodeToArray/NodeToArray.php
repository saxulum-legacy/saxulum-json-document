<?php

namespace Saxulum\JsonDocument\NodeToArray;

use Saxulum\JsonDocument\AbstractNode;

class NodeToArray
{
    /**
     * @var AbstractNodeToArrayHandler[]
     */
    protected $handlers;

    /**
     * @param array $handlers
     */
    public function __construct(array $handlers)
    {
        foreach ($handlers as $handler) {
            if (!$handler instanceof AbstractNodeToArrayHandler) {
                throw new \InvalidArgumentException("Handlers must extend AbstractNodeToArrayHandler!");
            }

            $handler->setMainHandler($this);
            $this->handlers[] = $handler;
        }
    }

    /**
     * @param  AbstractNode $node
     * @param  bool         $embedded
     * @return array
     */
    public function getArray(AbstractNode $node, $embedded = false)
    {
        foreach ($this->handlers as $handler) {
            if ($handler->isResponsible($node)) {
                return $handler->getArray($node, $embedded);
            }
        }
    }
}
