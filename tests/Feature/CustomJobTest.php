<?php

use App\Actions\CreateNewJob;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Queue;

it('test POST on /api/jobs with no payload', function () {
    $response = $this->post('/api/jobs');
    expect($response->getStatusCode())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('test POST on /api/jobs with errors in payload', function () {
    $response = $this->post('/api/jobs', [
        'text' => 'https://youtu.be/dQw4w9WgXcQ',
        'tasks' => ['call_actions', 'call_reason', 'hire_me'],
    ]);

    expect($response->getStatusCode())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
    expect($response->json())->toBe([
        'errors' => [
            'text' => ['The text field must not be greater than 10 characters.'],
            'tasks.2' => ['The selected tasks.2 is invalid.'],
        ],
    ]);
});

it('test POST on /api/jobs success', function () {
    $response = $this->post('/api/jobs', [
        'text' => 'Hire me!',
        'tasks' => ['call_actions', 'call_reason', 'call_segments', 'satisfaction', 'summary'],
    ]);

    expect($response->getStatusCode())->toBe(Response::HTTP_CREATED);
    expect($response->json())->toHaveKey('job_id');
    expect($response->json()['job_id'])->toBeUuid();
});

it('tests the post request on CreateNewJob creates queue entity', function () {
    Queue::fake();
    CreateNewJob::assertNotPushed();

    $this->post('/api/jobs', [
        'text' => 'Hi',
        'tasks' => ['call_actions'],
    ]);
    Queue::assertCount(1);
    CreateNewJob::assertPushedOn('default');
});

it('tests handle method creates five jobs', function () {
    Queue::fake();
    Queue::assertCount(0);
    $uuid = '00000000-0000-0000-0000-000000000001';
    $tasks = [
        'call_actions',
        'call_reason',
        'call_segments',
        'satisfaction',
        'summary',
    ];

    $createJob = new CreateNewJob();
    $createJob->handle($uuid, $tasks);

    Queue::assertCount(count($tasks));
    foreach ($tasks as $task) {
        ($createJob::DISPATCH_ACTIONS[$task])::assertPushedOn('default');
    }
});