<?php
/*
 * Copyright 2014 Stephen Coakley <me@stephencoakley.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy
 * of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace Switchbox;

use Switchbox\PropertyTree\Node;
use Switchbox\PropertyTree\NodeList;
use Switchbox\PropertyTree\RecursiveTreeIterator;

class DefaultExpressionEngine implements ExpressionEngineInterface
{
    /**
     * [querySelect description]
     *
     * @param  [type] $query [description]
     * @param  bool   $all   [description]
     *
     * @return NodeList
     */
    public function query($expression, Node $context)
    {
        $names = explode('.', $expression);
        $selectedNodes = new NodeList();

        $iterator = new \RecursiveIteratorIterator(
            $context->getChildNodes()->getIterator(),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        $iterator->setMaxDepth(count($names) - 1);
        foreach ($iterator as $node)
        {
            // path doesn't match expression
            if ($node->getName() != $names[$iterator->getDepth()])
            {
                // skip branch
                continue;
            }

            // matches & is at end of expression
            else if ($iterator->getDepth() === count($names) - 1)
            {
                $selectedNodes->addNode($node);
            }
        }

        // scar tissue?
        /*$names = explode('.', $expression);
        $baseNodes = new NodeList();
        $selectedNodes = new NodeList();

        $baseNodes->addNode($context);

        for ($i = 0; $i < count($names); $i++)
        {
            for ($j = 0; $j < count($baseNodes); $j++)
            {
                $childNodes = $baseNodes->getNode($j)->getChildNodes();

                foreach ($childNodes->getNodesByName($names[$i]) as $node)
                {
                    $selectedNodes->addNode($node);
                }
            }

            $baseNodes = clone $selectedNodes;
            $selectedNodes->clear();
        } */
       return $selectedNodes;
    }
}
