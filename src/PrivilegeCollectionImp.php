<?php
namespace Ylara;

class PrivilegeCollectionImp implements PrivilegeCollection
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function unpack()
    {
        return $this->routes;
    }

    public function flatten() : array
    {
        $result = [];
        foreach ($this->routes as $route) {
            $route_names = explode('.', $route);
            $history_names = [];
            foreach ($route_names as $route_name) {
                $history_names[] = $route_name;
                $result[] = implode('.', $history_names);
            }
        }

        return array_map(function ($item) {
            return [
                'name' => $item,
                'label' => $this->label($item)
            ];
        }, array_unique($result));
    }

    public function tree() : array
    {
        $permissions = $this->routes;
        $result = [];
        foreach ($permissions as $permission) {
            $route_names = explode('.', $permission);
            $item = &$result;
            $history_names = [];
            $history_labels = [];
            $routes_len = count($route_names);
            foreach ($route_names as $i => $route_name) {
                if ('' == $route_name) {
                    continue;
                }
                $history_names[] = $route_name;
                $history_labels[] = $this->label($route_name);
                $routes_name = implode('.', $history_names);
                if (!isset($item[$route_name])) {
                    $item[$route_name] = [
                        'label' => $this->label($route_name),
                        'name' => $routes_name,
                        'fullLabel' => implode('>', $history_labels)
                    ];
                    if ($i < $routes_len - 1) {
                        $item['children'] = [];
                        $item = &$item[$route_name]['children'];
                    }
                    continue;
                }
                $item = &$item[$route_name]['children'];
            }
        }

        return $result;
    }

    protected function label($route_name)
    {
        $route_names = explode('.', $route_name);
        $result = [];
        foreach ($route_names as $route) {
            $result[] = env(strtoupper($route), $route) ?? $route;
        }

        return implode('>', $result);
    }
}
