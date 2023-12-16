<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Income;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserIncomesTest extends TestCase
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
    public function it_gets_user_incomes(): void
    {
        $user = User::factory()->create();
        $incomes = Income::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.incomes.index', $user));

        $response->assertOk()->assertSee($incomes[0]->id);
    }

    /**
     * @test
     */
    public function it_stores_the_user_incomes(): void
    {
        $user = User::factory()->create();
        $data = Income::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.incomes.store', $user),
            $data
        );

        $this->assertDatabaseHas('incomes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $income = Income::latest('id')->first();

        $this->assertEquals($user->id, $income->user_id);
    }
}
