<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class CoursesTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateCourse(): void
    {
        factory('App\Models\Institution')->create();

        $this->post('/v1/courses', [
            "name" => 'New Course',
            "duration" => "2010-01-01",
            "status" => 1,
            "institution_id" => 1,
        ])->assertResponseStatus(Response::HTTP_CREATED);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => 'New Course',
            "duration" => "2010-01-01",
            "status" => 'Ativo',
            "institution_id" => 1,
        ]);
    }

    public function testUpdateCourse(): void
    {
        factory('App\Models\Institution')->create();
        factory('App\Models\Course')->create([
            "name" => 'New Course',
            "duration" => "2010-01-01",
            "status" => 1,
            "institution_id" => 1,
        ]);

        $this->put('/v1/courses/1', [
            "name" => 'Update Course',
            "duration" => "2020-01-01",
            "status" => 0,
            "institution_id" => 1,
        ])->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => 'Update Course',
            "duration" => "2020-01-01",
            "status" => 'Inativo',
            "institution_id" => 1,
        ]);
    }

    public function testGetAllCourses(): void
    {
        factory('App\Models\Institution')->create();
        factory('App\Models\Course', 4)->create([
            "institution_id" => 1,
        ]);

        $this->get('/v1/courses')
            ->assertResponseStatus(Response::HTTP_OK);

        $responseStructure = [
            [
                'id',
                'name',
                'duration',
                'status',
                'institution_id',
                'students',
                'updated_at',
                'created_at',
                'deleted_at'
            ]
        ];

        $this->seeJsonStructure($responseStructure);
    }

    public function testShowCourse(): void
    {
        factory('App\Models\Institution', 2)->create();
        factory('App\Models\Course')->create([
            "name" => 'Show Course',
            "duration" => "2020-09-01",
            "status" => 1,
            "institution_id" => 2,
        ]);

        $this->get('/v1/courses/1')
            ->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonContains([
            "id" => 1,
            "name" => 'Show Course',
            "duration" => "2020-09-01 00:00:00",
            "status" => 1,
            "institution_id" => 2,
        ]);
    }

    public function testDeleteCourse(): void
    {
        factory('App\Models\Institution', 2)->create();
        factory('App\Models\Course', 4)->create([
            "name" => 'Show Course',
            "duration" => "2020-09-01",
            "status" => 1,
            "institution_id" => 2,
        ]);

        $this->delete('/v1/courses/3')
            ->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnCreateRequest(?string $name, string $duration, int $status, int $institution_id): void
    {
        $this->post('/v1/courses', [
            "name" => $name,
            "duration" => $duration,
            "status" => $status,
            "institution_id" => $institution_id,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnPutRequest(?string $name, string $duration, int $status, int $institution_id): void
    {
        $this->put('/v1/courses/1', [
            "name" => $name,
            "duration" => $duration,
            "status" => $status,
            "institution_id" => $institution_id,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidParametersOnCreate(): array
    {
        return [
          //$course      $duration     $status  $instituion_id
          [null        , '2020-09-01', 1      , 1            ],
          ['New Course', '          ', 1      , 1            ],
          ['New Course', '2020-09-01', 3      , 1            ],
          ['New Course', '2020-09-01', 1      , 12           ],
        ];
    }
}
