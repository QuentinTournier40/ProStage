<?php

namespace Gedmo\Tree;

use Gedmo\Exception\InvalidArgumentException;

/**
 * This interface ensures a consistent API between repositories for the ORM and the ODM.
 *
 * @author Gustavo Falco <comfortablynumb84@gmail.com>
 * @author Gediminas Morkevicius <gediminas.morkevicius@gmail.com>
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
interface RepositoryInterface extends RepositoryUtilsInterface
{
    /**
     * Get all root nodes.
     *
     * @param string $sortByField
     * @param string $direction
     *
     * @return array
     */
    public function getRootNodes($sortByField = null, $direction = 'asc');

    /**
     * Returns an array of nodes optimized for building a tree.
     *
     * @param object $node        Root node
     * @param bool   $direct      Flag indicating whether only direct children should be retrieved
     * @param array  $options     Options, see {@see RepositoryUtilsInterface::buildTree()} for supported keys
     * @param bool   $includeNode Flag indicating whether the given node should be included in the results
     *
     * @return array
     */
    public function getNodesHierarchy($node = null, $direct = false, array $options = [], $includeNode = false);

    /**
     * Get the list of children for the given node.
     *
     * @param object|null          $node        The object to fetch children for; if null, all nodes will be retrieved
     * @param bool                 $direct      Flag indicating whether only direct children should be retrieved
     * @param string|string[]|null $sortByField Field name(s) to sort by
     * @param string               $direction   Sort direction : "ASC" or "DESC"
     * @param bool                 $includeNode Flag indicating whether the given node should be included in the results
     *
     * @return array|null List of children or null on failure
     */
    public function getChildren($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false);

    /**
     * Counts the children of the given node
     *
     * @param object|null $node   The object to count children for; if null, all nodes will be counted
     * @param bool        $direct Flag indicating whether only direct children should be counted
     *
     * @return int
     *
     * @throws InvalidArgumentException if the input is invalid
     */
    public function childCount($node = null, $direct = false);
}
