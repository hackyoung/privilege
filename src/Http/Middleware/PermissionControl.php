<?php
namespace Ylara\Http\Middleware;

use Ylara\Privilege;
use Illuminate\Support\Facades\Auth;

class PermissionControl
{
    public function handle($request, \Closure $next)
    {
        $route_name = $this->getRouteName($request);
        $privileges = $this->getPrivileges();
        if ($route_name && !app(Privilege::class)->contain($route_name, $privileges)) {
            throw new PrivilegeInvalidException;
        }

        return $next($request);
    }

    /**
     * 获取用户的权限
     */
    protected function getPrivileges() : array
    {
        $visitor = Auth::guard()->user;

        return $visitor->getPrivileges();
    }


    /**
     * 获取当前的权限点
     */
    protected function getRouteName($request) : string
    {
        return $request->getRoute()->getName();
    }
}
