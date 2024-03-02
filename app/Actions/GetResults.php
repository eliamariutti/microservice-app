<?php

namespace App\Actions;

use App\Models\Result;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\Concerns\AsAction;

class GetResults
{
    use AsAction;

    public function handle(string $uuid)
    {
        return Result::where('custom_job_id', $uuid)->get()->pluck('result')->toArray();
    }

    public function asController(string $uuid)
    {
        $validator = Validator::make(['uuid' => $uuid], [
            'uuid' => 'required|uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $results = $this->handle($uuid);

        return response()->json($results);
    }
}
