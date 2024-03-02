<?php

use App\Models\Result;
use Illuminate\Support\Str;

test('GET on /api/jobs with no parameters', function () {
    $response = $this->get('/api/jobs');

    $response->assertStatus(405);
});

test('GET on /api/jobs wrong parameters', function () {
    $response = $this->get('/api/jobs/hire_me');

    $response->assertStatus(422);
    expect($response->json())->toBe([
        'errors' => [
            'uuid' => ['The uuid field must be a valid UUID.'],
        ],
    ]);
});

test('GET on /api/jobs/{uuid} but no data', function () {
    $response = $this->get('/api/jobs/' . Str::uuid());

    $response->assertStatus(200);
    expect($response->json())->toBe([]);
});

test('GET on /api/jobs/{uuid} with data', function () {
    $results = Result::factory()->create();

    $uuid = $results->first()->first()->custom_job_id;
    $response = $this->get('/api/jobs/' . $uuid);

    $response->assertStatus(200);

    expect($response->json())->toBeArray();
    foreach ($response->json() as $result) {
        expect($result)->toMatch('/^Mock[A-Za-z]*Result$/');
    }
});
