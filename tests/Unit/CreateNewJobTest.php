<?php

use App\Actions\CreateNewJob;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

it('tests asController method', function () {
    $payload = [
        'text' => 'Test text',
        'tasks' => ['call_actions', 'call_reason'],
    ];
    $request = new Request($payload);
    $createJob = new CreateNewJob();

    $response = $createJob->asController($request);

    expect($response->getStatusCode())->toBe(Response::HTTP_CREATED);
});
