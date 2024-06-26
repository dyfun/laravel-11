<?php

namespace App\Services\TaskAssignService\Providers;

use App\Models\Task;
use App\Services\TaskAssignService\TaskAbstract;
use Illuminate\Support\Facades\Http;

class ProviderA extends TaskAbstract
{
    /**
     * @var ProviderA
     */
    private static ProviderA $instance;

    /**
     * @var string
     */
    private string $url = 'https://run.mocky.io/v3/9893a87f-9a86-41c9-b21f-5bf4893f6c59';

    /**
     * ProviderA constructor.
     */
    private function __construct() {}

    /**
     * @return ProviderA
     */
    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @return void
     */
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
