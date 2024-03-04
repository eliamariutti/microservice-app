<?php

namespace App\Actions;

use App\Models\Result;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;
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
            return new Response(
                ['errors' => $validator->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $results = $this->handle($uuid);

        return new Response($results, 200); // Or better 201 (Created)
    }

    public static function routes(Router $router): void
    {
        $router->get('/api/jobs/{uuid}', static::class)->name('get-results');
    }
}
