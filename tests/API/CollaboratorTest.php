<?php

declare(strict_types=1);

namespace App\Tests\API;

class CollaboratorTest extends AbstractAPITest 
{
    public function testGetCollaboratorsWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetCollaboratorsWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context"=> "/api/contexts/Collaborator",
            "@id"=> "/api/collaborators",
            "@type"=> "hydra:Collection",
            "hydra:totalItems"=> 2,
            "hydra:member"=> [
                [
                "@id"=> "/api/collaborators/plannings",
                "@type"=> "Collaborator",
                "id"=> 1,
                "familyName"=> "Vishvas",
                "givenName"=> "Anmol",
                "jobTitle"=> "Junior Software Engineer",
                "planning"=> [
                    "@id"=> "/api/plannings/details",
                    "@type"=> "Planning",
                    'id' => 1,
                    'name' => 'Planning 1',
                    'description' => 'Description Planning 1'
                ]
                ],
                [
                "@id"=> "/api/collaborators/plannings",
                "@type"=> "Collaborator",
                'id' => 2,
                "familyName"=> "Santilal",
                "givenName"=> "Vishvas",
                "jobTitle"=> "Shopkeeper",
                "planning"=> [
                    "@id"=> "/api/plannings/details",
                    "@type"=> "Planning",
                    "id"=> 2,
                    'name' => 'Planning 2',
                    'description' => 'Description Planning 2',
                ]
                ]
            ]
        ]);
    }

    public function testGetCollaboratorsWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostCollaboratorsWithoutLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'NewTest',
            'givenName' => 'TestNew',
            'jobTitle' => 'engineer'
        ]);

        $client=static::createClient();

        $client->request('POST', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testPostCollaboratorsWithUserLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'NewTest',
            'givenName' => 'TestNew',
            'jobTitle' => 'engineer'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPostCollaboratorsWithAdminLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'NewTest',
            'givenName' => 'TestNew',
            'jobTitle' => 'engineer'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPostCollaboratorsWithAdminLoginAndWithoutGivenName(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'NewTest',
            'givenName' => '',
            'jobTitle' => 'engineer'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);


        $client->request('POST', '/api/collaborators', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);
        $this->assertResponseStatusCodeSame(422);
    }

    public function testGetPlanningCollaboratorsWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/collaborators/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(500);
    }

    public function testGetPlanningCollaboratorsWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators/plannings', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context"=> "/api/contexts/Collaborator",
            "@id"=> "/api/collaborators/plannings",
            "@type"=> "hydra:Collection",
            "hydra:totalItems"=> 1,
            "hydra:member"=> [
                [
                    "@id"=> "/api/collaborators/plannings",
                    "@type"=> "Collaborator",
                    "id"=> 2,
                    "familyName"=> "Santilal",
                    "givenName"=> "Vishvas",
                    "jobTitle"=> "Shopkeeper"
                ]
            ]
        ]);
    }

    public function testGetCollaboratorWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('GET', '/api/collaborators/{id}', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetCollaboratorWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators/2', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            "@context"=> "/api/contexts/Collaborator",
            "@id"=> "/api/collaborators/2",
            "@type"=> "Collaborator",
            "id"=> 2,
            "familyName"=> "Santilal",
            "givenName"=> "Vishvas",
            "jobTitle"=> "Shopkeeper",
            "planning"=> [
                "@id"=> "/api/plannings/details",
                "@type"=> "Planning",
                "id"=> 2,
                "name"=> "Planning 2",
                "description"=> "Description Planning 2"
            ]
        ]);
    }

    public function testGetCollaboratorWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators/2', [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetCollaboratorWithAdminLoginAndWithoutId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators/', [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->assertResponseStatusCodeSame(301);
    }

    public function testGetCollaboratorWithAdminLoginAndWithNotExistingId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('GET', '/api/collaborators/99', [
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeleteCollaboratorWithAdminLogin(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/collaborators/3', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteCollaboratorWithUserLogin(): void
    {
        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/collaborators/1', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeleteCollaboratorWithoutLogin(): void
    {
        $client=static::createClient();

        $client->request('DELETE', '/api/collaborators/1', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testDeleteCollaboratorWithAdminLoginAndNotExistingId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/collaborators/99', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDeleteCollaboratorWithAdminLoginAndWithoutId(): void
    {
        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('DELETE', '/api/collaborators/', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPutCollaboratorWithAdminLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'Oukabay'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/collaborators/1', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    public function testPutCollaboratorWithUserLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'Oukabay'
        ]);

        $token = $this->loginUser("1684489109_Vishvas", "Vishvas");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/collaborators/1', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPutCollaboratorWithoutLogin(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'Oukabay'
        ]);

        $client = static::createClient();

        $client->request('PUT', '/api/collaborators/1', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testPutCollaboratorWithAdminLoginAndWithNotExistingId(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'Oukabay'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/collaborators/100', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testPutCollaboratorWithAdminLoginAndWithoutId(): void
    {

        $bodyContent = json_encode([
            'familyName' => 'Oukabay'
        ]);

        $token = $this->loginUser("1684483706_Anmol", "Anmol");

        $client = static::createClient([], ['headers' => ['authorization' => 'Bearer '.$token]]);

        $client->request('PUT', '/api/collaborators/', [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $bodyContent,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }
}