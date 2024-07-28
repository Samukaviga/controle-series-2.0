<?php

namespace Tests\Feature;

use App\Http\Requests\SeriesFormRequest;
use App\Repositories\SeriesRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesRepositoryTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_when_a_series_is_created_its_seasons_and_episodes_must_also_be_created()
    {
        //Todo teste tem 3 etapas

        //Arrange = prepara um cenario de testes

        $repository = $this->app->make(SeriesRepository::class);

        $request = new SeriesFormRequest();
        $request->nome = 'nome';
        $request->seasonsQty = 1;
        $request->episodesPerSeason = 1;

        //Act = Onde executamos o que queremos testar
        $repository->add($request);

        //Assert = verificamos o que executamos tem o resultado esperado
        $this->assertDatabaseHas('series', ['nome' => 'nome da Serie']);
        $this->assertDatabaseHas('seasons', ['number' => 1]);
        $this->assertDatabaseHas('episodes', ['number' => 1]);
    }
}
