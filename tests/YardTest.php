<?php

class YardTest extends TestCase
{
    public function testGetTasks()
    {
        $this->get('/yards/1/tasks');

        $this->seeJsonStructure(['data' => []]);
        $this->assertResponseStatus(200);
    }

    public function testPut()
    {
        $this->notSeeInDatabase('yard', ['name' => 'toto']);

        $this->put('/yards/1', [
            'name' => 'toto',
        ]);

        $this->seeInDatabase('yard', ['name' => 'toto']);
        $this->assertResponseStatus(200);
    }

    public function testPost()
    {
        $attributes = [
            'name' => 'toto',
            'deadline' => '2025-01-01',
        ];

        $this->notSeeInDatabase('yard', $attributes);

        $this->post('/yards', $attributes);

        $this->seeJson(array_merge($attributes, [
            'description' => null,
            'deadline' => "2025-01-01T00:00:00.000000Z",
            'archived' => null,
        ]));
        $this->seeInDatabase('yard', ['name' => 'toto']);
        $this->seeStatusCode(201);
    }

    public function testDelete()
    {
        $this->seeInDatabase('yard', ['id_yard' => 1]);

        $this->delete('/yards/1');

        $this->notSeeInDatabase('yard', ['id_yard' => 1]);
        $this->seeStatusCode(204);
    }
}
