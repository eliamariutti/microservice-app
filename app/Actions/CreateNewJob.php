<?php

namespace App\Actions;

use App\Models\CustomJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewJob
{
    use AsAction;

    const MAX_LENGTH = 10;

    const AVAILABLE_TASKS = [
        'call_actions',
        'call_reason',
        'call_segments',
        'satisfaction',
        'summary',
    ];

    const DISPATCH_ACTIONS = [
        'call_actions' => \App\Actions\Tasks\CallActions::class,
        'call_reason' => \App\Actions\Tasks\CallReason::class,
        'call_segments' => \App\Actions\Tasks\CallSegments::class,
        'satisfaction' => \App\Actions\Tasks\Satisfaction::class,
        'summary' => \App\Actions\Tasks\Summary::class,
    ];

    public function handle(string $uuid, array $tasks)
    {
        // Develop an action to provide a mock result for each task. (asynchronously)
        foreach ($tasks as $task) {
            $action = self::DISPATCH_ACTIONS[$task];
            $action::dispatch($uuid);
        }
    }

    public function asController(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|max:' . self::MAX_LENGTH,
            'tasks' => 'required|array',
            'tasks.*' => 'in:' . implode(',', self::AVAILABLE_TASKS),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new job
        $record = CustomJob::create([
            'created_at' => now(),
        ]);

        // Dispatch the job
        self::dispatch($record->id, $request->get('tasks'))->onQueue('default');

        // Return the job id
        return response()->json([
            'job_id' => $record->id,
        ]);
    }

    public function asJob(string $uuid, array $tasks)
    {
        return $this->handle($uuid, $tasks);
    }
}