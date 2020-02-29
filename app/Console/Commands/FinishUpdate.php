<?php

namespace App\Console\Commands;

use App\Events\UpdateFinished;
use Illuminate\Console\Command;

class FinishUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:finish {alias} {company} {new} {old}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finish the update process through CLI';

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

        $this->call('cache:clear');
        
        $alias = $this->argument('alias');
        $company_id = $this->argument('company');
        $new = $this->argument('new');
        $old = $this->argument('old');

        $this->info('Finishing ' . $alias . ' update command...');
        \Log::info('Finishing ' . $alias . ' update command...');

        // Check if the file mirror was successful
        if (($alias == 'core') && (version('short') != $new)) {
            $message = "Not able to finalize {$alias} installation";
            $this->error($message);
            \Log::info($message);
            throw new \Exception($message);
        }

        session(['company_id' => $company_id]);
        setting()->setExtraColumns(['company_id' => $company_id]);

        // Disable model cache during update
        config(['laravel-model-caching.enabled' => false]);

        event(new UpdateFinished($alias, $old, $new));
    }
}
