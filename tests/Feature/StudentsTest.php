<?php

use Illuminate\Http\Response;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Tests\TestCase;

class StudentsTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateCourse(): void
    {
        factory('App\Models\Institution')->create();
        factory('App\Models\Course')->create([
            "name" => 'New Course',
            "duration" => "2010-01-01",
            "status" => 1,
            "institution_id" => 1,
        ]);

        $this->post('/v1/students', [
            "name" => "Cezar Aluisio Pavelski",
            "cpf" => "222.222.222-44",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701413",
            "address" => "Rua das Flores",
            "number" => "333",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => 1,
            "course_id" => 1,
        ])->assertResponseStatus(Response::HTTP_CREATED);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => "Cezar Aluisio Pavelski",
            "cpf" => "222.222.222-44",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701413",
            "address" => "Rua das Flores",
            "number" => "333",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => "Ativo",
            "course_id" => 1,
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
        factory('App\Models\Student')->create([
            "name" => "Cezar Aluisio Pavelski",
            "cpf" => "222.222.222-44",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701013",
            "address" => "Rua das Flores",
            "number" => "102",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => 1,
            "course_id" => 1,
        ]);

        $this->put('/v1/students/1', [
            "name" => "Cezar Pavelski",
            "cpf" => "222.222.222-49",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701426",
            "address" => "Rua das Camelias",
            "number" => "222",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => 1,
            "course_id" => 1,
        ])->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonEquals([
            "id" => 1,
            "name" => "Cezar Pavelski",
            "cpf" => "222.222.222-49",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701426",
            "address" => "Rua das Camelias",
            "number" => "222",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => "Ativo",
            "course_id" => 1,
        ]);
    }

    public function testGetAllCourses(): void
    {
        factory('App\Models\Institution')->create();
        factory('App\Models\Course')->create([
            "name" => 'New Course1',
            "duration" => "2020-01-01",
            "status" => 1,
            "institution_id" => 1,
        ]);
        factory('App\Models\Student', 3)->create([
            "course_id" => 1,
        ]);

        $this->get('/v1/students')
            ->assertResponseStatus(Response::HTTP_OK);

        $responseStructure = [
            [
                'id',
                'name',
                'cpf',
                'birth_date',
                'email',
                'phone',
                'address',
                'number',
                'district',
                'city',
                'country',
                'status',
                'course_id',
                'updated_at',
                'created_at',
                'deleted_at'
            ]
        ];

        $this->seeJsonStructure($responseStructure);
    }

    public function testShowCourse(): void
    {
        factory('App\Models\Institution')->create();
        factory('App\Models\Course')->create([
            "name" => 'New Course',
            "duration" => "2010-01-01",
            "status" => 1,
            "institution_id" => 1,
        ]);
        factory('App\Models\Student')->create([
            "name" => "Cezar Aluisio Pavelski",
            "cpf" => "222.222.222-44",
            "birth_date" => "1984-01-09",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701013",
            "address" => "Rua das Flores",
            "number" => "102",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => 1,
            "course_id" => 1,
        ]);

        $this->get('/v1/students/1')
            ->assertResponseStatus(Response::HTTP_OK);

        $this->seeJsonContains([
            "name" => "Cezar Aluisio Pavelski",
            "cpf" => "222.222.222-44",
            "email" => "cezarpavelski@gmail.com",
            "phone" => "44 99701013",
            "address" => "Rua das Flores",
            "number" => "102",
            "district" => "Vila Bosque",
            "city" => "Maringá",
            "country" => "PR",
            "status" => 1,
            "course_id" => 1,
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
        factory('App\Models\Student', 2)->create([
            "course_id" => 3,
        ]);

        $this->delete('/v1/students/2')
            ->assertResponseStatus(Response::HTTP_OK);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnCreateRequest(
        ?string $name,
        string $cpf,
        string $birth_date,
        string $email,
        ?string $phone,
        ?string $address,
        ?string $number,
        ?string $district,
        ?string $city,
        ?string $country,
        int $status,
        int $course_id
    ): void
    {
        $this->post('/v1/students', [
            "name" => $name,
            "cpf" => $cpf,
            "birth_date" => $birth_date,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
            "number" => $number,
            "district" => $district,
            "city" => $city,
            "country" => $country,
            "status" => $status,
            "course_id" => $course_id,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @dataProvider invalidParametersOnCreate
     */
    public function testInvalidParametersOnPutRequest(
        ?string $name,
        string $cpf,
        string $birth_date,
        string $email,
        ?string $phone,
        ?string $address,
        ?string $number,
        ?string $district,
        ?string $city,
        ?string $country,
        int $status,
        int $course_id
    ): void
    {
        $this->put('/v1/students/1', [
            "name" => $name,
            "cpf" => $cpf,
            "birth_date" => $birth_date,
            "email" => $email,
            "phone" => $phone,
            "address" => $address,
            "number" => $number,
            "district" => $district,
            "city" => $city,
            "country" => $country,
            "status" => $status,
            "course_id" => $course_id,
        ])->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function invalidParametersOnCreate(): array
    {
        return [
            //$name  $cpf                  $birth_date   $email             $phone        $address $number $district $city      $country $status $course_id
            [null  , '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '00.000.000/0001-11', '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '19840109'  , 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'www.gmail.com'  , '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', null        , 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', null   , '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', null  , 'Vila B', 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , null    , 'Maringá', 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', null     , 'PR'   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', null   , 1     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 3     , 1],
            ['Joao', '222.222.222-44'    , '1984-01-09', 'cezar@gmail.com', '4499701413', 'Rua A', '2A'  , 'Vila B', 'Maringá', 'PR'   , 1     , 16],
        ];
    }
}
