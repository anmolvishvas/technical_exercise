<?php

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UserTest extends ApiTestCase 
{
    public function testLoginWithExistingCredentials(){
        $client=static::createClient();

        $client->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode(
                [
                    "username"=> "1684483706_Anmol",
                    "password"=> "Anmol"
                ]
            ),
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testLoginWithoutCredentials(){
        $client=static::createClient();

        $client->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json']
        ],);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testLoginWithNotExistingCredentials(){
        $client=static::createClient();

        $client->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode(
                [
                    "username"=> "1684483706_Anmol2",
                    "password"=> "Anmol2"
                ]
            ),
        ],);

        $this->assertResponseStatusCodeSame(401);
    }
}