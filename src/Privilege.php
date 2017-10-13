<?php
namespace Ylara\Providers;

interface PrivilegeServiceProvider
{
    /**
     * 从Route收集权限
     *
     * @return PrivilegeCollection
     */
    public function gather() : PrivilegeCollection;

    /**
     * 将收集的权限存储到存储器
     *
     * @param PrivilegeCollection privilges
     *
     * @return bool
     */
    public function store(PrivilegeCollection $privileges) : bool;

    /**
     * 从存储中取出所有权限
     *
     * @return PrivilegeCollection
     */
    public function fetch() : PrivilegeCollection;

    /**
     * privCol是否包含privPoint
     *
     * @param string privPoint 权限点
     * @param array privCol 权限点的集合
     *
     * @return bool
     */
    public function contain(string $privPoint, array $privCol) : bool;

    /**
     * 移除已存在的权限
     */
    public function remove() : bool;
}
