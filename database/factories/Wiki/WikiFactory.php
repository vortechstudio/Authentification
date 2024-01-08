<?php

namespace Database\Factories\Wiki;

use App\Models\Wiki\Wiki;
use App\Models\Wiki\WikiCategory;
use App\Models\Wiki\WikiSubcategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wiki\Wiki>
 */
class WikiFactory extends Factory
{
    protected $model = Wiki::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cat = WikiCategory::all()->random()->id;
        $posted = $this->faker->boolean;

        return [
            'title' => $this->faker->sentence(random_int(5, 9), true),
            'synopsis' => $this->faker->realText(130),
            'content' => $this->faker->paragraphs(random_int(1, 5), true),
            'wiki_category_id' => $cat,
            'wiki_subcategory_id' => WikiSubcategory::where('wiki_category_id', $cat)->get()->random()->id,
            'posted' => $posted,
            'posted_at' => $posted ? now()->subDays(random_int(0, 15)) : null,
        ];
    }
}
