<?php

namespace Modules\Inventory\Console;

use Illuminate\Console\Command;

class InventorySeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:seed {company}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed inventory data for new company';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $class = $this->laravel->make(\Modules\Inventory\Database\Seeders\InventorySeeder::class);

        $seeder = $class->setContainer($this->laravel)->setCommand($this);

        $seeder->__invoke();
    }
}
