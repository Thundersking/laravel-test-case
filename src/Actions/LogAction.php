<?php

namespace Vion\TestCase\Actions;

use Illuminate\Support\Facades\Log;

class LogAction
{
    /**
     * Log error for test
     *
     * @param string $path
     * @param $response
     * @return void
     */
    public function error(string $path, $response)
    {
        $channel = Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/Tests/' . $path),
        ]);

        Log::stack(['slack', $channel])->error([
            'Error ' . $response->status() => $response->json() ?? $response->body(),
        ]);
    }
}
