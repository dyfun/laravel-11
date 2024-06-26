<?php

namespace App\Console\Commands;

use App\Models\Provider;
use App\Services\TaskService\TaskService;
use Illuminate\Console\Command;

class FetchTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch task from providers and save to database';

    /**
     * Create a new command instance.
     */
    public function __construct(private readonly TaskService $taskService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
        $providers = Provider::all();

        $providers->each(function ($provider) {
            $this->taskService->setProvider($provider);
            $this->taskService->fetch();
        });
    }
}
