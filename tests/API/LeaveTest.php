<?php

declare(strict_types=1);

namespace App\Tests\API;

class LeaveTest extends AbstractAPITest 
{
    public function testGetLeavesWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetLeavesWithLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context"=> "/api/contexts/Leave",
        "@id"=> "/api/leaves",
        "@type"=> "hydra:Collection",
        "hydra:totalItems"=> 15,
        "hydra:member"=> [
            [
            "@id"=> "/api/leaves/plannings",
            "@type"=> "Leave",
            'id' => 16,
      'startDate' => '2023-05-24T00:00:00+02:00',
      'endDate' => '2023-05-30T00:00:00+02:00',
     'reason' => 'paid',
            "collaborator"=> [
                "@id"=> "/api/collaborators/plannings",
                "@type"=> "Collaborator",
                "id"=> 2,
                "familyName"=> "Santilal",
                "givenName"=> "Vishvas",
                "jobTitle"=> "Shopkeeper"
            ],
            "numberOfDays"=> 5,
            "planning"=> "/api/plannings/details"
        ],
            [
            "@id"=> "/api/leaves/plannings",
            "@type"=> "Leave",
            'id' => 17,
      'startDate' => '2023-05-24T00:00:00+02:00',
      'endDate' => '2023-05-30T00:00:00+02:00',
            "reason"=> "paid",
            "collaborator"=> [
                "@id"=> "/api/collaborators/plannings",
                "@type"=> "Collaborator",
                "id"=> 2,
                "familyName"=> "Santilal",
                "givenName"=> "Vishvas",
                "jobTitle"=> "Shopkeeper"
            ],
            "numberOfDays"=> 5,
            "planning"=> "/api/plannings/details"
        ],
        [
            "@id"=> "/api/leaves/plannings",
            "@type"=> "Leave",
            "id"=> 18,
            "startDate"=> "2023-05-24T00:00:00+02:00",
            'endDate' => '2023-05-30T00:00:00+02:00',
          'reason' => 'paid',
            "collaborator"=>[ 
                "@id"=> "/api/collaborators/plannings",
                "@type"=> "Collaborator",
                "id"=> 2,
                "familyName"=> "Santilal",
                "givenName"=> "Vishvas",
                "jobTitle"=> "Shopkeeper"
            ],
            "numberOfDays"=> 5,
            "planning"=> "/api/plannings/details"
            ]
        ]
        ]);
    }

    public function testPostLeavesWithCredentials(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '/api/collaborators/2',
            'planning' => '/api/plannings/5'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPostLeavesWithoutCredentials(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '/api/collaborators/2',
            'planning' => '/api/plannings/5'
        ]);

        $client = static::createClient();

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testPostLeavesWithoutPlannindIRI(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '/api/collaborators/2',
            'planning' => ''
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostLeavesWithoutCollaboratorIRI(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '',
            'planning' => '/api/plannings/5'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostLeavesWithNotExistingCollaborator(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '/api/collaborators/12',
            'planning' => ''
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostLeavesWithNotExistingPlanning(): void
    {
        $bodyContent = json_encode([
            'startDate' => '2023-05-24T10:23:31.088Z',
            'endDate' => '2023-05-31T10:23:31.088Z',
            'reason' => 'paid',
            'collaborator' => '',
            'planning' => '/api/plannings/95'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('POST', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testGetPlannningLeavesWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/leaves/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testGetPlannningLeavesWithLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/leaves/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context"=> "/api/contexts/Leave",
            "@id"=> "/api/leaves/plannings",
            "@type"=> "hydra:Collection",
            "hydra:totalItems"=> 2,
            "hydra:member"=> [
                [
                    "@id"=> "/api/leaves/plannings",
                    "@type"=> "Leave",
                    'id' => 2,
                    'startDate' => '2023-05-24T00:00:00+02:00',
                    'endDate' => '2023-05-30T00:00:00+02:00',
                    "reason"=> "unpaid",
                    "collaborator"=> [
                        "@id"=> "/api/collaborators/plannings",
                        "@type"=> "Collaborator",
                        'id' => 1,
                        'givenName' => 'Anmol',
                        'jobTitle' => 'Junior Software Engineer'
                    ],
                    "numberOfDays"=> 5,
                    "planning"=> "/api/plannings/details"
                ],
                [
                    "@id"=> "/api/leaves/plannings",
                    "@type"=> "Leave",
                    'id' => 17,
                    "startDate"=> "2023-05-24T00:00:00+02:00",
                    'endDate' => '2023-05-30T00:00:00+02:00',
                    "reason"=> "paid",
                    "collaborator"=> [
                        "@id"=> "/api/collaborators/plannings",
                        "@type"=> "Collaborator",
                        "id"=> 2,
                        "familyName"=> "Santilal",
                        "givenName"=> "Vishvas",
                        "jobTitle"=> "Shopkeeper"
                    ],
                    "numberOfDays"=> 5,
                    "planning"=> "/api/plannings/details"
                ]
                
            ]
        ]);
    }
}