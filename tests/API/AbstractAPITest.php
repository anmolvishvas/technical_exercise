<?php

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

abstract class AbstractAPITest extends ApiTestCase
{
    protected function loginUser(string $username, string $password):?string {
        $client=static::createClient();

        $response = $client->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode(
                [
                    "username"=> $username,
                    "password"=> $password
                ]
            ),
        ]);
        return !empty($response->toArray()['token']) ?$response->toArray()['token'] :null;
    }
}