<?php

namespace Tests\Feature;

use App\Modules\TestCase\Services\FaultTestService;
use App\Modules\TestCase\Services\UserTestService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FaultTest extends TestCase
{
    use DatabaseTransactions;
    protected ?Model $user;
    protected ?Model $fault;

    protected function setUp(): void
    {
        parent::setUp();
        $userService = $this->app->make(UserTestService::class);
        $this->user = $userService->create();

        $faultService = $this->app->make(FaultTestService::class);
        $this->fault = $faultService->create();

        $this->list_structure = [
            'data',
            'links',
            'meta',
        ];

        $this->detail_structutre = [
            'data'
        ];

    }


    public function test_list()
    {
        $response = $this->actingAs($this->user)->get('api/v1/faults');
        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_show()
    {
        $response = $this->actingAs($this->user)->get('api/v1/faults/some-ru');
        $response->assertOk();
        $response->assertJsonStructure($this->detail_structutre);
    }

    public function test_list_search()
    {
        $response = $this->actingAs($this->user)
            ->get('api/v1/faults?q=some');

        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_list_filter_category()
    {
        $response = $this->actingAs($this->user)
            ->get('api/v1/faults?filter[category_id]=1');

        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_list_filter_node()
    {
        $response = $this->actingAs($this->user)
            ->get('api/v1/faults?filter[node_categories]=1');

        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_list_filter_guarantee()
    {
        $response = $this->actingAs($this->user)
            ->get('api/v1/faults?filter[guarantee_id]=1');

        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_list_filter_tag()
    {
        $response = $this->actingAs($this->user)
            ->get('api/v1/faults?filter[tags]=1');

        $response->assertOk();
        $response->assertJsonStructure($this->list_structure);
    }

    public function test_add_favor()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/favorites', [
            'slug' => 'some-ru'
        ]);
        $response->assertCreated();
    }

    public function test_remove_favor()
    {
        $response = $this->actingAs($this->user)->post('/api/v1/favorites', [
            'slug' => 'some-ru'
        ]);

        $response->assertCreated();

        $response = $this->actingAs($this->user)->delete('/api/v1/favorites', [
            'slug' => ['some-ru']
        ]);

        $response->assertCreated();
    }

}
