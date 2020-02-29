<?php

namespace App\Console\Commands;

use App\Utilities\Console;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Module;

class UpdateTerminal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:terminal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to update Akaunting and modules directly through CLI';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        set_time_limit(0); // unlimited

        $core_modules = ['offlinepayment', 'paypalstandard'];

        $modules = Module::all();

        // Delete module files
        foreach ($modules as $module) {
            $alias = $module->getAlias();

            if (in_array($alias, $core_modules)) {
                continue;
            }

            File::deleteDirectory($module->getPath());
        }

        $this->info('Starting update...');

        // Update core
        if ($this->applyUpdate('core', '2.0.2') !== true) {
            $message = 'Not able to update core from terminal';
            $this->error($message);
            \Log::info($message);
            return;
        }

        // Update modules
        foreach ($modules as $module) {
            $alias = $module->get('alias');

            if (in_array($alias, $core_modules)) {
                continue;
            }

            if ($this->applyUpdate($alias, '2.0.0') !== true) {
                $message = 'Not able to update ' . $alias . ' from terminal';
                $this->error($message);
                \Log::info($message);
                return;
            }
        }
    }
    
    protected function applyUpdate($alias, $version)
    {
        $this->info('Updating ' . $alias . '...');

        $command = "php artisan update {$alias} 1 {$version}";

        if (true !== $result = Console::run($command, true)) {
            $message = !empty($result) ? $result : trans('modules.errors.finish', ['module' => $alias]);

            \Log::info($message);

            if ($alias == 'core') {
                return false;
            }
        }

        return true;
    }
}
