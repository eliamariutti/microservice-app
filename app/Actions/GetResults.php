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

    public function handle(string $uuid): array
    {
        return Result::where('custom_job_id', $uuid)->get()->pluck('result')->toArray();
    }
    /**
     * @OA\Get(
     *     path="/api/jobs/{jobId}",
     *     summary="Get mock results for a job",
     *     @OA\Parameter(
     *         name="jobId",
     *         in="path",
     *         description="ID of the job to retrieve results for",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Mock results retrieved successfully",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="string")
     *         )
     *     )
     * )
     */
    public function asController(string $uuid): Response
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
