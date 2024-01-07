<?php

namespace Database\Factories\Support\Ticket;

use App\Models\Service;
use App\Models\Support\Ticket\Ticket;
use App\Models\Support\Ticket\TicketCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['open', 'closed', 'pending']);
        $priority = $this->faker->randomElement(['low', 'medium', 'high']);
        $user = User::all()->random();
        $service = Service::all()->random();
        $category = TicketCategory::where('service_id', $service->id)->get()->random();
        return [
            'title' => $this->faker->word(),
            'status' => $status,
            'priority' => $priority,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => $user->id,
            'service_id' => $service->id,
            'ticket_category_id' => $category->id,
        ];
    }
}
