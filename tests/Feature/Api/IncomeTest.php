<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Income;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_incomes_list(): void
    {
        $incomes = Income::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.incomes.index'));

        $response->assertOk()->assertSee($incomes[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_income(): void
    {
        $data = Income::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.incomes.store'), $data);

        $this->assertDatabaseHas('incomes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_income(): void
    {
        $income = Income::factory()->create();

        $user = User::factory()->create();

        $data = [
            'amount' => $this->faker->randomNumber(1),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.incomes.update', $income), $data);

        $data['id'] = $income->id;

        $this->assertDatabaseHas('incomes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_income(): void
    {
        $income = Income::factory()->create();

        $response = $this->deleteJson(route('api.incomes.destroy', $income));

        $this->assertModelMissing($income);

        $response->assertNoContent();
    }
}
