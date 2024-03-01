<?php

namespace App\Actions\Tasks;

use App\Models\Result;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class AbstractMockAction
{
    use AsAction;

    public function handle(string $uuid)
    {
        Result::create([
            'custom_job_id' => $uuid,
            'result' => 'Mock' . class_basename($this) . 'Result',
        ]);
    }

    public function asJob(string $uuid)
    {
        return $this->handle($uuid);
    }
}