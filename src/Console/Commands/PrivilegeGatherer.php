<?php
namespace Ylara\Console\Commands;

use Illuminate\Console\Command;
use Ylara\Privilege;

class PrivilegeGatherer extends Command
{
    protected $signature = 'privileges:gather {--force}';

    protected $description = '通过路由自动收集权限';

    protected $privilege;

    public function __construct(Privilege $privilege)
    {
        parent::__construct();
        $this->privilege = $privilege;
    }

    public function handle()
    {
        if ($this->option('force')) {
            $this->privilege->remove();
        }
        if ($this->privilege->exists()) {
            $this->info('权限已经存在，您可以用--force选项强制收集权限');
        }
        $privilege = $this->privilege->gather();
        $this->privilege->store($privilege);

        $this->info('权限生成完成，可以使用privilege:list查看');
    }
}
