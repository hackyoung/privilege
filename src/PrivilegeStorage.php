<?php
namespace Ylara;

interface PrivilegeStorage
{
    /**
     * 检查是否有已经存在的权限
     */
    public function exists() : bool;

    /**
     * 保存权限
     */
    public function save(array $privileges) : bool;

    /**
     * 取权限点
     */
    public function fetch() : array;

    /**
     * 移除所有权限点
     */
    public function remove() : bool;
}
