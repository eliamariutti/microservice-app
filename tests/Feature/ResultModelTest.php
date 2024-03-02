<?php

use App\Models\Result;
use App\Models\CustomJob;

it('creates and retrieves a result', function () {
    $customJob = CustomJob::factory()->create();
    $resultData = [
        'custom_job_id' => $customJob->id,
        'result' => 'Test result',
    ];

    Result::create($resultData);
    $retrievedResult = Result::first();

    expect($retrievedResult->custom_job_id)->toBe($resultData['custom_job_id']);
    expect($retrievedResult->result)->toBe($resultData['result']);
});