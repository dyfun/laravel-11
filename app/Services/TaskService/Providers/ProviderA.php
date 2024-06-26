<?php

namespace App\Services\TaskService\Providers;

use App\Models\Task;
use App\Services\TaskService\TaskAbstract;
use Illuminate\Support\Facades\Http;

class ProviderA extends TaskAbstract
{
    private static ProviderA $instance;

    private string $url = 'https://run.mocky.io/v3/9893a87f-9a86-41c9-b21f-5bf4893f6c59';

    /**
     * ProviderA constructor.
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
                'value' => $task['value'],
                'estimated_duration' => $task['estimated_duration'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        });

        Task::insert($bulkData);
    }
}
