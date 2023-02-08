<?php


function buildTree(array $array): ? array
    {

        $keyed = array();
        foreach ($array as & $value)
        {
            $keyed[$value['id']] = & $value;
        }
        unset($value);
        $array = $keyed;
        unset($keyed);

        // tree it
        $tree = array();
        foreach ($array as & $value)
        {
            if ($parent = $value['parent']) $array[$parent]['children'][] = & $value;
            else $tree[] = & $value;
        }
        unset($value);
        $array = $tree;
        unset($tree);

        return $array;
    }

    
?>