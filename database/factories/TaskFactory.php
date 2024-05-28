<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->realText(mt_rand(10, 100)),
            'is_completed' => fake()->randomElement([0, 0, 1]),
            'user_id' => fake()->randomElement(User::hass_less_than_5_completed_tasks()),
            'company_id' => Company::inRandomOrder()->first()->id,
            'expired_at' => fake()->randomElement([null, Carbon::now()->subDays(mt_rand(0, 365))])
        ];
    }


    public function configure(): static
    {
        return $this->afterMaking(function(Task $task) {
            if($task->expired_at != null) {
                $task->start_at = Carbon::parse($task->expired_at)->subDays(mt_rand(5, 10));
                $task->save();
            };
        });
    }
    
}
