<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class optimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moneder:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute other comands for traslation routes';

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
        // running `php artisan optimize`
        $this->warn('Execution comanda php artisan optimize');
        $optimize = shell_exec('php artisan optimize');
        $this->info($optimize);

        // running `php artisan optimize`
        // $this->warn('Execution php artisan route:trans:cache');
        // $optimize = shell_exec('php artisan route:trans:cache');
        // $this->info($optimize);

        // running `php artisan optimize`
        $this->warn('Execution php artisan route:clear');
        $optimize = shell_exec('php artisan route:clear');
        $this->info($optimize);
    }
}
