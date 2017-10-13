<?php
namespace Ylara\Console\Commands;

use Illuminate\Console\Command;
use Ylara\Privilege;

class PrivilegeDisplay extends Command
{
    protected $signature = 'privileges:display';

    protected $description = '列出目前系统收集并正在使用的权限';

    protected $privilege;

    public function __construct(Privilege $privilege)
    {
        parent::__construct();
        $this->privilege = $privilege;
    }

    public function handle()
    {
        $this->info('权限点及分组');
        $this->info('--------------------------------------------------------');
        $privileges = $this->privilege->fetch()->tree();
        foreach ($privileges as $privilege) {
            $depth = 0;
            $this->printPrivilege($privilege, $depth);
        }
    }

    protected function printPrivilege($privilege, &$depth)
    {
        if (!isset($privilege['label'])) {
            return;
        }
        $this->info($this->tab($depth) . $privilege['label']);
        if (!isset($privilege['children'])) {
            return;
        }
        ++$depth;
        foreach ($privilege['children'] as $priv) {
            $this->printPrivilege($priv, $depth);
        }
        --$depth;
    }

    private function tab($depth)
    {
        $tab = '';
        for ($i = 0; $i < $depth; ++$i) {
            $tab .= "\t\t";
        }

        return $tab;
    }
}
