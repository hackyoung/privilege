<?php
namespace Ylara\Providers;

use Illuminate\Support\ServiceProvider;
use Ylara\Privilege;
use Ylara\PrivilegeImp;
use Ylara\PrivilegeCollection;
use Ylara\PrivilegeCollectionImp;
use Ylara\PrivilegeStorage;
use Ylara\FilePrivilegeStorage;

class PrivilegeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Privilege::class, function () {
            return app(PrivilegeImp::class);
        });
        $this->app->bind(PrivilegeCollection::class, function (array $routes) {
            return new PrivilegeCollectionImp($routes);
        });
        $this->app->bind(PrivilegeStorage::class, function () {
            return app(FilePrivilegeStorage::class);
        });
    }
}
