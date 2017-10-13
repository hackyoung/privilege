<?php
namespace Ylara;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class PrivilegeImp implements Privilege
{
    private $routes;

    private $storage;

    public function __construct(Router $router)
    {
        $this->routes = $router->getRoutes();
        $this->storage = app(PrivilegeStorage::class);
    }

    public function gather() : PrivilegeCollection
    {
        return PrivilegeCollectionImp::newFromRoutes($this->getRoutes());
    }

    public function exists() : bool
    {
        return $this->storage->exists();
    }

    public function store(PrivilegeCollection $privileges) : bool
    {
        if ($this->storage->exists()) {
            throw new \Exception('已有权限存在，请先删除再继续操作');
        }

        return $this->storage->save($privileges->unpack());
    }

    public function remove() : bool
    {
        return $this->storage->remove();
    }

    public function fetch() : PrivilegeCollection
    {
        if (!$this->storage->exists()) {
            throw new \Exception('请先创建权限');
        }

        return PrivilegeCollectionImp::newFromRoutes($this->storage->fetch());
    }

    public function contain(string $privPoint, array $privCol) : bool
    {
        $names = explode('.', $privPoint);
        $his = [];
        foreach ($names as $name) {
            $his[] = $name;
            $group[] = implode('.', $his);
        }

        return !empty(array_intersect($privCol, $group));
    }

    /**
     * Compile the routes into a displayable format.
     *
     * @return array
     */
    protected function getRoutes()
    {
        $routes = collect($this->routes)->map(function ($route) {
            return $route->getName();
        })->all();

        return array_filter($routes);
    }
}
