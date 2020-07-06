<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class InstitutionsTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateInstitution(): void
    {
        $this->post('/v1/institutions', [
            "name" => "New Institution",
	        "cnpj" => "00.000.000/0000-22",
	        "status" => 1,
        ])->assertResponseStatus(Response::HTTP_CREATED);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => "New Institution",
            "cnpj" => "00.000.000/0000-22",
            "status" => 'Ativo',
        ]);
    }

    public function testUpdateInstitution(): void
    {
        factory('App\Models\Institution')->create();

        $this->put('/v1/institutions/1', [
            "name" => "Update Institution",
            "cnpj" => "00.000.000/0000-22",
            "status" => 0,
        ])->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => "Update Institution",
            "cnpj" => "00.000.000/0000-22",
            "status" => 'Inativo',
        ]);
    }

    public function testGetAllInstitutions(): void
    {
        factory('App\Models\Institution', 2)->create();

        $this->get('/v1/institutions')
            ->assertResponseStatus(Response::HTTP_OK);

        $responseStructure = [
            [
                'id',
                'name',
                'cnpj',
                'status',
                'courses',
                'updated_at',
                'created_at',
                'deleted_at'
            ]
        ];

        $this->seeJsonStructure($responseStructure);
    }

    public function testShowInstitution(): void
    {
        factory('App\Models\Institution')->create([
            "name" => "Show Institution",
            "cnpj" => "00.000.000/0000-22",
            "status" => 1,
        ]);

        $this->get('/v1/institutions/1')
            ->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonContains([
            "id" => 1,
            "name" => "Show Institution",
            "cnpj" => "00.000.000/0000-22",
            "status" => 1,
        ]);
    }

    public function testDeleteInstitution(): void
    {
        factory('App\Models\Institution', 3)->create();

        $this->delete('/v1/institutions/3')
            ->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnCreateRequest(?string $name, string $cnpj, int $status): void
    {
        $this->post('/v1/institutions', [
            "name" => $name,
            "cnpj" => $cnpj,
            "status" => $status,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnPutRequest(?string $name, string $cnpj, int $status): void
    {
        $this->put('/v1/institutions/1', [
            "name" => $name,
            "cnpj" => $cnpj,
            "status" => $status,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidParametersOnCreate(): array
    {
        return [
            //$name           $cnpj                   $status
            [null             , '00.000.000/0001-22', 1],
            ['New Institution', '000.000.000-44'    , 1],
            ['New Institution', '0.000.000/0001-22' , 3],
            ['New Institution', '0.000.000/0001-22' , 1],
        ];
    }
}
