<?php

class ChantiersTest extends TestCase
{
    public function testGetMissions()
    {
        $this->get('/chantiers/1/missions');

        $this->seeJsonStructure(['data' => []]);
        $this->assertResponseStatus(200);
    }

    public function testPut()
    {
        $this->notSeeInDatabase('chantier', ['nom' => 'toto']);

        $this->put('/chantiers/1', [
            'nom' => 'toto',
        ]);

        $this->seeInDatabase('chantier', ['nom' => 'toto']);
        $this->assertResponseStatus(200);
    }

    public function testPost()
    {
        $attributes = [
            'nom' => 'toto',
            'deadline' => '2025-01-01',
        ];

        $this->notSeeInDatabase('chantier', $attributes);

        $this->post('/chantiers', $attributes);

        $this->seeJson(array_merge($attributes, [
            'description' => null,
            'deadline' => "2025-01-01T00:00:00.000000Z",
            'archiver' => null
        ]));
        $this->seeInDatabase('chantier', ['nom' => 'toto']);
        $this->seeStatusCode(201);
    }

    public function testDelete()
    {
        $this->seeInDatabase('chantier', ['id_chantier' => 1]);

        $this->delete('/chantiers/1');

        $this->notSeeInDatabase('chantier', ['id_chantier' => 1]);
        $this->seeStatusCode(204);
    }
}
