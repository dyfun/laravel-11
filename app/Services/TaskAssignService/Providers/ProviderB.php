<?php

namespace App\Services\TaskAssignService\Providers;

use App\Models\Task;
use App\Services\TaskAssignService\TaskAbstract;
use Illuminate\Support\Facades\Http;

class ProviderB extends TaskAbstract
{
    private static ProviderB $instance;

    private string $url = 'https://run.mocky.io/v3/5b206d95-d093-4c38-b984-e9c2e1e2fba2';

    /**
     * ProviderB constructor.
     */
    private function __construct() {}

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    public function fetch(): void
    {
        $response = Http::get($this->url);
        $tasks = collect($response->json());

        $bulkData = [];
        $tasks->each(function ($task) use (&$bulkData) {
            $bulkData[] = [
                'value' => $task['zorluk'],
                'estimated_duration' => $task['sure'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        Task::insert($bulkData);
    }
}
