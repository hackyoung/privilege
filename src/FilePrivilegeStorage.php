<?php
namespace Ylara;

class FilePrivilegeStorage implements PrivilegeStorage
{
    private $pathfile;

    public function __construct($pathfile = null)
    {
        $this->pathfile = $pathfile ?? self::defaultPathfile();
    }

    public function exists() : bool
    {
        if (is_file($this->pathfile)) {
            return true;
        }

        return false;
    }

    public function fetch() : array
    {
        if (!$this->exists()) {
            throw new \RuntimeException('不存在权限点, 请先生成!');
        }

        return json_decode(file_get_contents($this->pathfile), true);
    }

    public function remove() : bool
    {
        if ($this->exists()) {
            unlink($this->pathfile);
        }

        return true;
    }

    public function save(array $privileges) : bool
    {
        $dir = explode('/', $this->pathfile);
        array_pop($dir);

        if (!is_dir(implode('/', $dir))) {
            mkdir($dir, 0744, true);
        }
        file_put_contents($this->pathfile, json_encode(array_values($privileges)));

        return true;
    }

    private static function defaultPathfile()
    {
        return base_path() . '/' . trim(env(
            'PRIVILEGE_SAVE_PATHFILE', 'storage/app/privilege'
        ), '/');
    }
}
