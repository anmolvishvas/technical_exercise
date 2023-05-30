<?php

declare(strict_types=1);

namespace App\Tests\Api;

class PlanningTest extends AbstractApiTest 
{
    public function testGetPlanningsWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetPlanningsWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Planning',
            '@id' => '/api/plannings',
            "@type"=> "hydra:Collection",
            'hydra:totalItems' => 5,
            "hydra:member"=> [
            [
                "@id"=> "/api/plannings/details",
                "@type"=> "Planning",
                "id"=> 1,
                'name' => 'Planning 1',
                'description' => 'Description Planning 1',
                "collaborators"=> [],
                "leaves"=> [ 
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 1,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "unpaid",
                        'numberOfDays' => 5
                    ],
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 16,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "paid",
                        "numberOfDays"=> 5
                    ]
                ]
            ]
        ]
        ]);
    }

    public function testGetPlanningsWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostPlanningsWithoutLogin(): void
    {

        $bodyContent = json_encode([
            'name' => 'Test',
            'description' => 'TestNew'
        ]);

        $client=static::createClient();

        $client->request('POST', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testPostPlanningsWithUserLogin(): void
    {

        $bodyContent = json_encode([
            'name' => 'Test',
            'description' => 'TestNew'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostCollaboratorsWithAdminLogin(): void
    {

        $bodyContent = json_encode([
            'name' => 'Test',
            'description' => 'TestNew'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testGetPlanningDetailsWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/plannings/details', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testGetPlanningDetailsWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/details', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Planning',
            '@id' => '/api/plannings/details',
            "@type"=> "hydra:Collection",
            'hydra:totalItems' => 1,
            "hydra:member"=> [
            [
                "@id"=> "/api/plannings/details",
                "@type"=> "Planning",
                "id"=> 1,
                'name' => 'Planning 1',
                'description' => 'Description Planning 1',
                "collaborators"=> [],
                "leaves"=> [ 
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 1,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "unpaid",
                        'numberOfDays' => 5
                    ],
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 16,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "paid",
                        "numberOfDays"=> 5
                    ]
                ]
            ]
            ]
        ]);
    }

    public function testGetPlanningDetailsWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/details', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Planning',
            '@id' => '/api/plannings/details',
            "@type"=> "hydra:Collection",
            'hydra:totalItems' => 1,
            "hydra:member"=> [
            [
                "@id"=> "/api/plannings/details",
                "@type"=> "Planning",
                "id"=> 2,
                'name' => 'Planning 2',
                'description' => 'Description Planning 2',
                "collaborators"=> [],
                "leaves"=> [ 
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 2,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "unpaid",
                        'numberOfDays' => 5
                    ],
                    [
                        "@id"=> "/api/leaves/plannings",
                        "@type"=> "Leave",
                        'id' => 17,
                        'startDate' => '2023-05-24T00:00:00+00:00',
                        'endDate' => '2023-05-30T00:00:00+00:00',
                        "reason"=> "paid",
                        "numberOfDays"=> 5
                    ]
                ]
            ]
            ]
        ]);
    }

    public function testGetPlanningWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/plannings/', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetPlanningWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/2', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Planning',
            '@id' => '/api/plannings/2',
            "@type"=> "Planning",
            "id"=> 2,
            'name' => 'Planning 2',
            'description' => 'Description Planning 2',
            "collaborators"=> [],
            "leaves"=> [ 
                [
                    "@id"=> "/api/leaves/plannings",
                    "@type"=> "Leave",
                    'id' => 2,
                    'startDate' => '2023-05-24T00:00:00+00:00',
                    'endDate' => '2023-05-30T00:00:00+00:00',
                    "reason"=> "unpaid",
                    'numberOfDays' => 5
                ],
                [
                    "@id"=> "/api/leaves/plannings",
                    "@type"=> "Leave",
                    'id' => 17,
                    'startDate' => '2023-05-24T00:00:00+00:00',
                    'endDate' => '2023-05-30T00:00:00+00:00',
                    "reason"=> "paid",
                    "numberOfDays"=> 5
                ]
            ]
        ]);
    }

    public function testGetPlanningWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/2', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetPlanningWithAdminLoginAndWithoutId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(301);
    }

    public function testGetPlanningWithAdminLoginAndWithNotExistingId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/plannings/888', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeletePlanningWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/plannings/6', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeletePlanningWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/plannings/1', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeletePlanningWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('DELETE', '/api/plannings/1', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeletePlanningWithAdminLoginAndNotExistingId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/plannings/99', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeletePlanningWithAdminLoginAndWithoutId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/plannings/', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPutPlanningWithAdminLogin(): void
    {
        $bodyContent = json_encode([
            'name' => 'Presentation'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/plannings/5', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPutPlanningWithUserLogin(): void
    {

        $bodyContent = json_encode([
            'name' => 'Presentation'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/plannings/1', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPutPlanningWithoutLogin(): void
    {
        $bodyContent = json_encode([
            'name' => 'Presentation'
        ]);

        $client = static::createClient();

        $client->request('PUT', '/api/plannings/1', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPutPlanningWithAdminLoginAndWithNotExistingId(): void
    {
        $bodyContent = json_encode([
            'name' => 'Presentation'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/plannings/100', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPutPlanningWithAdminLoginAndWithoutId(): void
    {
        $bodyContent = json_encode([
            'name' => 'Presentation'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/plannings/', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPostAddCollaboratorInPlanningWithoutLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $client=static::createClient();

        $client->request('POST', '/api/plannings/3/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostAddCollaboratorInPlanningWithUserLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/3/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostAddCollaboratorInPlanningWithAdminLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/3/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPostAddCollaboratorInPlanningWithAdminLoginAndWithoutId(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(405);
    }

    public function testPostAddCollaboratorInPlanningWithAdminLoginAndWithNotExistingId(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/300/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testPostAddCollaboratorInPlanningWithAdminLoginAndWithoutCollaboratorIRI(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
               '2' 
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/2/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostAddCollaboratorInPlanningWithAdminLoginAndWithNotExistingCollaboratorIRI(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
               '/api/collaborators/6' 
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/2/add_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostRemoveCollaboratorInPlanningWithoutLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $client=static::createClient();

        $client->request('POST', '/api/plannings/3/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testPostRemoveCollaboratorInPlanningWithUserLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/3/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostRemoveCollaboratorInPlanningWithAdminLogin(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/3/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testPostRemoveCollaboratorInPlanningWithAdminLoginAndWithoutId(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(405);
    }

    public function testPostRemoveCollaboratorInPlanningWithAdminLoginAndWithNotExistingId(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
                "/api/collaborators/1"
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/300/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPostRemoveCollaboratorInPlanningWithAdminLoginAndWithoutCollaboratorIRI(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
               '2' 
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/2/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }

    public function testPostRemoveCollaboratorInPlanningWithAdminLoginAndWithNotExistingCollaboratorIRI(): void
    {
        $bodyContent = json_encode([
            "collaborators" => 
            [
               '/api/collaborators/6' 
            ]
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/plannings/2/remove_collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(400);
    }
}