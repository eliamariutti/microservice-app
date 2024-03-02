<?php

namespace Database\Factories;

use App\Actions\CreateNewJob;
use App\Models\CustomJob;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'custom_job_id' => CustomJob::factory()->create(),
            'result' => $this->faker->randomElement([
                'MockCallActionsResult',
                'MockCallReasonResult',
                'MockCallSegmentsResult',
                'MockSatisfactionResult',
                'MockSummaryResult',
            ]),
        ];
    }
}
