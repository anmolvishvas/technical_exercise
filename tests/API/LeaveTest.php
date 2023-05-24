<?php

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class LeaveTest extends AbstractAPITest 
{
    public function testGetLeavesWithoutLogin(){
        $client=static::createClient();

        $client->request('GET', '/api/leaves', [
            'headers' => ['Content-Type' => 'application/json']
        ]);

        $this->assertResponseStatusCodeSame(403);
    }

    public function testGetLeavesWithLogin(){
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
}