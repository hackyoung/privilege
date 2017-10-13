<?php
namespace Ylara;

interface PrivilegeCollection
{
    /**
     * 返回树形结构的权限点
     *
     * @return array
     * [{
     *      name: (string),
     *      label: (string),
     *      fullLabel: (string),
     *      children: [{
     *          name: (string),
     *          label: (string),
     *          fullLabel: (string),
     *          children: []
     *      }]
     * }]
     */
    public function tree() : array;

    /**
     * 返回扁平结构的权限点
     *
     * @return array
     * [{
     *      name: (string),
     *      label: (string)
     * }]
     */
    public function flatten() : array;
}
