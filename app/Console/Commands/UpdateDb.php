<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\Install\UpdateFinished;

class UpdateDb extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:db {alias=core} {company=1} {new=2.0.3} {old=1.3.18}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allows to update Akaunting database manually';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $alias = $this->argument('alias');
        $company_id = $this->argument('company');
        $new = $this->argument('new');
        $old = $this->argument('old');

        session(['company_id' => $company_id]);
        setting()->setExtraColumns(['company_id' => $company_id]);

        // Disable model cache during update
        config(['laravel-model-caching.enabled' => false]);

        event(new UpdateFinished($alias, $new, $old));
    }
}
