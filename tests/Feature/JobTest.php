<?php

// use Illuminate\Foundation\Testing\RefreshDatabase;

// uses(RefreshDatabase::class);

test('POST on /api/jobs', function () {
    $response = $this->post('/api/jobs');
    $response->assertStatus(422);
});

test('POST on /api/jobs with errors', function () {
    $response = $this->post('/api/jobs', [
        'text' => 'Hello World',
        'tasks' => ['call_actions', 'call_reason', 'hire_me'],
    ]);

    $response->assertStatus(422);

    expect($response->json())->toBe([
        'errors' => [
            'text' => ['The text field must not be greater than 10 characters.'],
            'tasks.2' => ['The selected tasks.2 is invalid.'],
        ],
    ]);
});

test('POST on /api/jobs success', function () {
    $response = $this->post('/api/jobs', [
        'text' => 'Hire me!',
        'tasks' => ['call_actions', 'call_reason', 'call_segments', 'satisfaction', 'summary'],
    ]);

    $response->assertStatus(200);

    expect($response->json())->toHaveKey('job_id');
    expect($response->json()['job_id'])->toBeUuid();
});
