<?php

use function Pest\Stressless\stress;

it('tests post endpoint success rate', function () {
    $result = stress(route('create-new-job'))
        ->post([
            'text' => 'stress !',
            'tasks' => [
                'call_actions',
                'satisfaction'
                ]
            ])
        ->concurrency(2)
        ->duration(3)
        ->verbosely();

    expect($result->requests()->failed()->count())->toBe(0);
});

it('test GET endpoint success rate', function () {
    $response = $this->post(
        route('create-new-job'),
        [
            'text' => 'Come on',
            'tasks' => [
                'call_actions',
                'satisfaction'
            ]
        ]);

    $result = stress(route('get-results', ['uuid' => $response->json('job_id')]))
        ->get()
        ->concurrency(2)
        ->duration(3)
        ->verbosely();

    expect($result->requests()->failed()->count())->toBe(0);
});