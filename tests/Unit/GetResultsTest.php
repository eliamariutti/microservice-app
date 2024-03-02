<?php

use App\Actions\GetResults;
use Illuminate\Http\Response;

beforeEach(function () {
    $this->mock = \Mockery::mock(GetResults::class)
        ->makePartial();
});

it('tests asController method', function () {
    $uuid = '00000000-0000-0000-0000-000000000000';

    $this->mock
        ->shouldReceive('handle')
        ->with($uuid)
        ->andReturn(['Pippo', 'Pluto', 'Paperino'])
        ->getMock();

    $response = $this->mock->asController($uuid);

    expect($response->getStatusCode())->toBe(Response::HTTP_OK);
    expect($response->getContent())->toBeJson();
    expect($response->getContent())->toBe('["Pippo","Pluto","Paperino"]');
});

it('tests asController method with invalid uuid', function () {
    $uuid = 'invalid-uuid';

    $this->mock
        ->shouldReceive('handle')
        ->never()
        ->getMock();

    $response = $this->mock->asController($uuid);

    expect($response->getStatusCode())->toBe(Response::HTTP_UNPROCESSABLE_ENTITY);
    expect($response->getContent())->toBeJson();
    expect($response->getContent())->toBe('{"errors":{"uuid":["The uuid field must be a valid UUID."]}}');
});
