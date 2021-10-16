<?php

class UserTest extends TestCase
{
    public function testShow()
    {
        $this->get('/users/1');

        $this->seeJsonStructure([
            'id_user',
            'name',
            'description',
            'type',
            'email',
            'phone',
            'id_enterprise',
        ]);
        $this->seeStatusCode(200);
    }

    public function testGetYards()
    {
        $this->get('/users/1/yards');

        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id_yard',
                    'name',
                    'description',
                    'archived',
                    'deadline',
                    'project_owner',
                    'supervisor',
                ],
            ],
        ]);
        $this->seeStatusCode(200);
    }

    public function testGetAvailabilities()
    {
        $this->get('/users/1/availabilities');

        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id_availability',
                    'start',
                    'end',
                    'id_user',
                ],
            ],
        ]);
        $this->seeStatusCode(200);
    }

    public function testGetNotifications()
    {
        $this->get('/users/notifications');

        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id_notification',
                    'creation',
                    'is_read',
                    'parameters',
                    'id_recipient',
                    'id_notification_type',
                ]
            ]
        ]);
        $this->seeStatusCode(200);
    }

    public function testUpdate()
    {
        $this->put('/users', [
            'name' => 'toto',
            'description' => 'foo bar',
            'email' => 'toto@mail.net',
            'phone' => '0123456789',
        ]);

        $this->seeJsonContains([
            'id_user' => 1,
            'name' => 'toto',
            'description' => 'foo bar',
            'email' => 'toto@mail.net',
            'phone' => '0123456789',
        ]);
        $this->seeStatusCode(200);
    }

    public function testCreate()
    {
        $this->post('/users', [
            'name' => 'toto',
            'description' => 'foo bar',
            'type' => 'project_owner',
            'email' => 'toto@mail.net',
            'phone' => '0123456789',
            'password' => 'testpassword',
            'password_confirmation' => 'testpassword'
        ]);

        $this->seeJsonContains([
            'id_user' => 21,
            'name' => 'toto',
            'description' => 'foo bar',
            'email' => 'toto@mail.net',
            'phone' => '0123456789',
        ]);
        $this->seeStatusCode(201);
    }
}
