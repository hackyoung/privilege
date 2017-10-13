<?php
namespace YlaraTest;

require_once dirname(dirname(__FILE__)) . '/src/Providers/PrivilegeStorage.php';
require_once dirname(dirname(__FILE__)) . '/src/Providers/FilePrivilegeStorage.php';

use PHPUnit\Framework\TestCase;
use Ylara\Providers\FilePrivilegeStorage;

class FilePrivilegeStorageTest extends TestCase
{
    private $pathfile;

    private $privileges = [
        'centre.member.index',
        'centre.member.store',
        'centre.member.update'
    ];

    public function testNewFilePrivilegeStorage()
    {
        $this->pathfile = dirname(__FILE__) . '/file_privilege';

        return new FilePrivilegeStorage($this->pathfile);
    }

    /**
     * @depends testSave
     */
    public function testExists(FilePrivilegeStorage $storage)
    {
        $this->assignEquals($storage->isExists(), true);

        return $storage;
    }

    /**
     * @depends testNewFilePrivilegeStorage
     */
    public function testSave(FilePrivilegeStorage $storage)
    {
        $storage->save($this->privileges);

        $this->assignEquals(is_file($pathfile), true);
        $this->assignEquals($this->privileges, file_get_contents($pathfile));

        return $storage;
    }

    /**
     * @depends testExists
     */
    public function testFetch(FilePrivilegeStorage $storage)
    {
        $this->assignEquals($storage->fetch(), $this->privileges);
    }
}
