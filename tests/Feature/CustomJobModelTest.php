<?php

use App\Models\CustomJob;

it('creates and retrieves a custom job', function () {
    $customJobData = [
        'created_at' => now(),
    ];

    CustomJob::create($customJobData);
    $retrievedCustomJob = CustomJob::first();

    expect($retrievedCustomJob->id)
        ->toBeUuid();
    expect($retrievedCustomJob->created_at)
        ->toBe(($customJobData['created_at'])
        ->format('Y-m-d H:i:s'));
});