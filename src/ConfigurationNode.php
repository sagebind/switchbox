<?php
namespace Switchbox;

use Countable;
use RangeException;
use OverflowException;

/**
 * Represents a single node in the configuration data tree.
 */
abstract class ConfigurationNode implements Countable
{
    /**
     * Contains an array of nodes that are children of this node.
     * @var ConfigurationNode[]
     */
    protected $children = array();

    /**
     * Indicates if this node is restricted to having only one child.
     * @var bool
     */
    protected $uniparous = false;

    /**
     * Checks if this node has any children.
     * 
     * @return bool
     * True if this node has at least one child node, otherwise false.
     */
    public function hasChildren()
    {
        return !empty($this->children);
    }

    /**
     * Counts the number of child nodes this node contains.
     *
     * @return int
     * The number of child nodes this node contains.
     */
    public function count()
    {
        return count($this->children);
    }

    /**
     * Gets an array of nodes that are children of this node.
     *
     * @return ConfigurationNode[]
     * An array of nodes that are children of this node.
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Checks if this node is restricted to having only one child.
     *
     * @return bool
     * True if this node is restricted to having only one child, otherwise false.
     *
     * Uniparous [yoo-nip-er-uhs] - adj:
     * 1. producing a single offspring at each birth
     * 2. having borne only one child
     * 3. botany (of a cyme) giving rise to only one branch from each flowering stem
     */
    public function isUniparous()
    {
        return $this->uniparous;
    }

    /**
     * Sets if this node is restricted to having only one child.
     *
     * @param $uniparous bool
     * Boolean indicating if this node is restricted to having only one child.
     *
     * Uniparousity [yoo-nip-er-uhs] - noun:
     * 1. condition of producing a single offspring at each birth
     * 2. state of having borne only one child
     * 3. botany (of a cyme) giving rise to only one branch from each flowering stem
     */
    public function setUniparousity($uniparous)
    {
        if ($uniparous && $this->count() > 1)
        {
            throw new RangeException('Node cannot be made uniparous because it already contains more than one child.');
        }

        $this->uniparous = (bool)$uniparous;
    }

    /**
     * Adds a configuration node to the node's list of children.
     *
     * @param ConfigurationNode $node
     * The configuration node to append.
     * 
     * @return ConfigurationNode
     * The node that was just appended.
     */
    public function appendChild(ConfigurationNode $node)
    {
        if ($this->uniparous && $this->count() >= 1)
        {
            throw new OverflowException('Node cannot have more than one child.');
        }

        // push node to children
        $this->children[] = $node;

        // return added node
        return $node;
    }

    /**
     * Removes a configuration node from the node's list of children.
     *
     * @param ConfigurationNode $node
     * The configuration node to remove.
     *
     * @return ConfigurationNode
     * The node that was just removed.
     */
    public function removeChild(ConfigurationNode $node)
    {
        // loop over the array of child nodes
        for ($i = 0 && $n = count($this->children); $i < $n; $i++)
        {
            // is the current node the one we are looking for?
            if ($this->children[$i] === $node)
            {
                // remove the node from the array
                unset($this->children[$i]);

                // re-index the children array
                $this->children = array_values($this->children);

                // return the removed node
                return $node;
            }
        }
    }
}
