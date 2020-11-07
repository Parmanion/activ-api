<?php


namespace App\Tests\Functional;


use App\Entity\User;
use App\Factory\UserFactory;
use App\Tests\CustomTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class AuthenticationTest extends CustomTestCase
{
    use ResetDatabase;
    use Factories;

    public function testLoginWithWrongCredential()
    {
        $client = self::createClient();
        $password = 'my password';
        $user = UserFactory::new()->create(['password' => $password]);

        // Request with a fake password
        $response = $client->request('POST', '/login', [
            'json' => [
                'email' => $user->getEmail(),
                'password' => 'fake paswword',
            ]
        ]);

        self::assertResponseStatusCodeSame(401);
        self::assertMatchesJsonSchema(self::jsonSchemaAuthResponse['wrongCredentials']);
        self::assertJson($response->getContent(false), '{"code": 401, "message": "Invalid credentials."}');

        // Request with a fake password
        $response = $client->request('POST', '/login', [
            'json' => [
                'email' => 'fakeemail@example.com',
                'password' => $password,
            ]
        ]);

        self::assertResponseStatusCodeSame(401);
        self::assertMatchesJsonSchema(self::jsonSchemaAuthResponse['wrongCredentials']);
        self::assertJson($response->getContent(false), '{"code": 401, "message": "Invalid credentials."}');

    }

    public function testLoginWithSuccess()
    {
        $password = 'my password';
        $client = self::createClient();

        $user = UserFactory::new()->create(['password' => $password]);

        $client->request('POST', '/login', [
            'json' => [
                'email' => $user->getEmail(),
                'password' => $password,
            ]
        ]);

        self::assertResponseStatusCodeSame(200);
        self::assertMatchesJsonSchema(self::jsonSchemaAuthResponse['successful']);

    }

    private const jsonSchemaAuthResponse = [
        'successful' => '
        {
            "type": "object",
            "description": "Successful authentication response",
            "examples": [
                {
                    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDQ3NDQzNjEsImV4cCI6MTYwNDc0Nzk2MSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiQWRhaCIsImZpcnN0TmFtZSI6IkFkYWgiLCJsYXN0TmFtZSI6IlJlaWNoZWwiLCJlbWFpbCI6Ind6aWVtYW5uQGV4YW1wbGUubmV0In0.kzbDaGIMvlGBCo8RXYWjTuRajl8s-xqrufBXnm_O8xh3CPHRdbDRkHNLPIzP4M7at-TBN3LnlYU2TmldEl-SCiV-mJlJY_9cR8wFdR-pvIXIATubu2b7FBrUeyciZucjwMqVd8rcZj4YPWTJx5aryFxaF8rNNep3iLnnrynZfN2fVvdUyq7EYDXZtEupdhLzkaibzG6_C1aYelvyG_utkbqUVespFyyIVAOkgbT3jy-i2Rr5wSoL9j-PPBjL1lwm5FLjcdl9mH5ZMhE_irn26fxBu0RN0HhBt-m5CpbLynbp_m0ufihMeTMtYYO3nIeH0yy5VC9CZPJeUVSRPHFioelDN1suVZOcnfJmHdBg4YSZj4ake466TnW5i3uBX4KNjyUBkMy23LKYuPGztVN-1ShtJxISCBeLnVyIIHvayTzliEaPoCRuAv9Hu0tcMH844KqvjrQJMcM40bDltrHfUAV5fE1HPPGMH8lNEdpVmxdh5bQUYcORKosSxIKIYbZLaPLkCqzlehnkgrOUq8Wr4yDZCNUgJWgoY7jaz_fLZdpSIuphoSauDQt2gtQZRaDPEpOqb4Gq7rRMuSvkYyzF4HQSNqucJFa8cEIW_-DJs7n_utCJ8aiWiV9mBs7dhUR0hwAv3fMP1hePiwNDwXhk_AeZUlRmgDwXBFVU-IyWmEI",
                    "firstName": "Adah",
                    "lastName": "Reichel",
                    "email": "wziemann@example.net"
                }
            ],
            "required": [
                "token",
                "firstName",
                "lastName",
                "email"
            ],
            "properties": {
                "token": {
                    "type": "string",
                    "title": "The JWT",
                    "examples": [
                        "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDQ3NDQzNjEsImV4cCI6MTYwNDc0Nzk2MSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiQWRhaCIsImZpcnN0TmFtZSI6IkFkYWgiLCJsYXN0TmFtZSI6IlJlaWNoZWwiLCJlbWFpbCI6Ind6aWVtYW5uQGV4YW1wbGUubmV0In0.kzbDaGIMvlGBCo8RXYWjTuRajl8s-xqrufBXnm_O8xh3CPHRdbDRkHNLPIzP4M7at-TBN3LnlYU2TmldEl-SCiV-mJlJY_9cR8wFdR-pvIXIATubu2b7FBrUeyciZucjwMqVd8rcZj4YPWTJx5aryFxaF8rNNep3iLnnrynZfN2fVvdUyq7EYDXZtEupdhLzkaibzG6_C1aYelvyG_utkbqUVespFyyIVAOkgbT3jy-i2Rr5wSoL9j-PPBjL1lwm5FLjcdl9mH5ZMhE_irn26fxBu0RN0HhBt-m5CpbLynbp_m0ufihMeTMtYYO3nIeH0yy5VC9CZPJeUVSRPHFioelDN1suVZOcnfJmHdBg4YSZj4ake466TnW5i3uBX4KNjyUBkMy23LKYuPGztVN-1ShtJxISCBeLnVyIIHvayTzliEaPoCRuAv9Hu0tcMH844KqvjrQJMcM40bDltrHfUAV5fE1HPPGMH8lNEdpVmxdh5bQUYcORKosSxIKIYbZLaPLkCqzlehnkgrOUq8Wr4yDZCNUgJWgoY7jaz_fLZdpSIuphoSauDQt2gtQZRaDPEpOqb4Gq7rRMuSvkYyzF4HQSNqucJFa8cEIW_-DJs7n_utCJ8aiWiV9mBs7dhUR0hwAv3fMP1hePiwNDwXhk_AeZUlRmgDwXBFVU-IyWmEI"
                    ]
                },
                "firstName": {
                    "type": "string",
                    "examples": [
                        "Adah"
                    ]
                },
                "lastName": {
                    "type": "string",
                    "examples": [
                        "Reichel"
                    ]
                },
                "email": {
                    "type": "string",
                    "examples": [
                        "wziemann@example.net"
                    ]
                }
            },
            "additionalProperties": true
        }',
        'wrongCredentials' => '
        {
            "type": "object",
            "description": "Authentication response for wrong credentials",
            "examples": [
                {
                    "code": "401",
                    "message": "Invalid credentials."
                }
            ],
            "required": [
                "code",
                "message"
            ],
            "properties": {
                "code": {
                    "type": "integer",
                    "title": "Error response 401",
                    "examples": [
                        401
                    ]
                },
                "message": {
                    "type": "string",
                    "examples": [
                        "Invalid credentials."
                    ]
                }
            },
            "additionalProperties": true
        }'
    ];
}
