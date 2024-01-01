<?php

namespace Tests\Feature\Railway\Cards;

use App\Livewire\Admin\Railway\Cards\CardModal;
use App\Livewire\Admin\Railway\Cards\CardsList;
use App\Livewire\Forms\Admin\Railway\Cards\CardForm;
use App\Models\Railway\Engine;
use App\Models\Railway\RailwayAdvantageCard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Tests\TestCase;

class RailwayAdvantageCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_railway_save_advantage_card()
    {
        $this->assertEquals(0, RailwayAdvantageCard::count());

        Livewire::test(CardModal::class)
            ->set('form.type', 'argent')
            ->set('form.class', 'third')
            ->set('form.qte', 1)
            ->set('form.tpoint_cost', 1)
            ->call('save');

        $this->assertEquals(1, RailwayAdvantageCard::count());
    }

    public function test_railway_update_advantage_card()
    {
        $this->assertEquals(0, RailwayAdvantageCard::count());

        $card = RailwayAdvantageCard::factory()->create([
            "type" => "argent",
            "class" => "third",
        ]);

        Livewire::test(CardModal::class, ['card' => $card])
            ->set('form.type', 'argent')
            ->set('form.class', 'third')
            ->set('form.qte', 50000)
            ->set('form.tpoint_cost', 10)
            ->call('save');

        $this->assertEquals(1, RailwayAdvantageCard::count());
        $this->assertEquals('argent', RailwayAdvantageCard::first()->type);
        $this->assertEquals(50000, RailwayAdvantageCard::first()->qte);
        $this->assertEquals(10, RailwayAdvantageCard::first()->tpoint_cost);
    }

    public function test_railway_generate_card_by_console()
    {
        $this->assertEquals(0, RailwayAdvantageCard::count());

        Engine::factory()->createMany(5);

        Artisan::call('create', ["action" => "cards"]);

        $this->assertEquals(251, RailwayAdvantageCard::count());
    }

    public function test_railway_unsave_card_cause_required_field()
    {
        $this->assertEquals(0, RailwayAdvantageCard::count());

        Livewire::test(CardModal::class)
            ->set('form.type', 'argent')
            ->set('form.class', 'third')
            ->set('form.qte', 1)
            ->set('form.tpoint_cost', 1)
            ->call('save');

        $this->assertEquals(1, RailwayAdvantageCard::count());

        Livewire::test(CardModal::class)
            ->set('form.type', '')
            ->set('form.class', 'third')
            ->set('form.qte', 1)
            ->set('form.tpoint_cost', 1)
            ->call('save')
            ->assertHasErrors(['type' => 'required']);
    }
}
