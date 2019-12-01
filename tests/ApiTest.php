<?php

declare(strict_types=1);

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use TaskTracker\Database\Migration;
use TaskTracker\Database\Seeds;
use TaskTracker\Persistence\TaskRepositoryOrm;
use TaskTracker\Persistence\UserRepositoryOrm;

class ApiTest extends TestCase
{

    /**
     * @var Migration
     */
    private $migration;

    /**
     * @var Seeds
     */
    private $seeds;

    /**
     * @var GuzzleHttp\Client
     */
    protected $client;


    protected function setUp(): void
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => 'http://' . getenv('NGINX_HOST') . ':8000'
        ]);

        $this->migration = new Migration();
        $this->seeds = new Seeds(new UserRepositoryOrm(), new TaskRepositoryOrm());

        $this->migration->up();
        $this->seeds->seed();
    }


    public function testGetTask()
    {
        $response = $this->client->get('/task/1');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertArrayHasKey('id', $data['message']);
        $this->assertArrayHasKey('name', $data['message']);
        $this->assertArrayHasKey('description', $data['message']);
        $this->assertArrayHasKey('status', $data['message']);
        $this->assertArrayHasKey('user_id', $data['message']);

        $this->assertEquals(1, $data['message']['id']);
        $this->assertEquals("Read a book", $data['message']['name']);
        $this->assertEquals("Find, buy and read \"PHP Internals\" book", $data['message']['description']);
        $this->assertEquals("planned", $data['message']['status']);
        $this->assertEquals(1, $data['message']['user_id']);
    }


    public function testGetAllTasks()
    {
        $response = $this->client->get('/task');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertArrayHasKey('id', $data['message'][2]);
        $this->assertArrayHasKey('name', $data['message'][2]);
        $this->assertArrayHasKey('description', $data['message'][2]);
        $this->assertArrayHasKey('status', $data['message'][2]);
        $this->assertArrayHasKey('user_id', $data['message'][2]);

        $this->assertEquals(3, $data['message'][2]['id']);
        $this->assertEquals("Have a cup of coffee", $data['message'][2]['name']);
        $this->assertEquals("Go to kitchen and drink a coffee", $data['message'][2]['description']);
        $this->assertEquals("planned", $data['message'][2]['status']);
        $this->assertEquals(2, $data['message'][2]['user_id']);
    }


    public function testCreateTask()
    {
        $postData = [
            "name" => "This is new task",
            "description" => "This task is just created",
            "user_id" => 1,
        ];

        $response = $this->client->post('/task', ['json' => $postData]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertArrayHasKey('id', $data['message']);
        $this->assertArrayHasKey('name', $data['message']);
        $this->assertArrayHasKey('description', $data['message']);
        $this->assertArrayHasKey('user_id', $data['message']);

        $this->assertEquals($postData['name'], $data['message']['name']);
        $this->assertEquals($postData['description'], $data['message']['description']);
        $this->assertEquals($postData['user_id'], $data['message']['user_id']);
    }


    public function testPutTask()
    {
        $postData = [
            "name" => "This is new task",
            "description" => "This task is just created",
            "status" => "planned",
            "user_id" => 1,
        ];

        $response = $this->client->put('/task/2', ['json' => $postData]);

        $this->assertEquals(200, $response->getStatusCode());


        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertEquals(['Success'], $data['message']);

        $response = $this->client->get('/task/2');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertArrayHasKey('id', $data['message']);
        $this->assertArrayHasKey('name', $data['message']);
        $this->assertArrayHasKey('description', $data['message']);
        $this->assertArrayHasKey('status', $data['message']);
        $this->assertArrayHasKey('user_id', $data['message']);

        $this->assertEquals(2, $data['message']['id']);
        $this->assertEquals($postData['name'], $data['message']['name']);
        $this->assertEquals($postData['description'], $data['message']['description']);
        $this->assertEquals("planned", $data['message']['status']);
        $this->assertEquals(1, $data['message']['user_id']);
    }

    public function testDeleteTask()
    {
        $response = $this->client->delete('/task/4');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $response = $this->client->get('/task/4');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);
        $this->assertEquals([], $data['message']);
    }

    public function testGetAllUsers()
    {
        $response = $this->client->get('/user');

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);

        $this->assertArrayHasKey('status', $data);
        $this->assertEquals(true, $data['status']);

        $this->assertArrayHasKey('message', $data);

        $this->assertEquals(2, count($data['message']));

        $this->assertArrayHasKey('id', $data['message'][0]);
        $this->assertArrayHasKey('name', $data['message'][0]);
        $this->assertArrayHasKey('email', $data['message'][0]);


        $this->assertEquals(1, $data['message'][0]['id']);
        $this->assertEquals("First User", $data['message'][0]['name']);
        $this->assertEquals("firstemail@example.com", $data['message'][0]['email']);

        $this->assertEquals(2, $data['message'][1]['id']);
        $this->assertEquals("Second User", $data['message'][1]['name']);
        $this->assertEquals("secondemail@example.com", $data['message'][1]['email']);
    }
}
