<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use App\Entity\ApiToken;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProductsTest extends ApiTestCase
{
    //use RefreshDatabaseTrait;

    private const API_TOKEN = '30f31604f100de1c143fd840fdce95bc4976b0400429b48a788e42871434de498aadf3c85365bc01c8a1f8a7a15050b659c02f4e5fc5a983c0c30fa3';

    private Client $client;

    private EntityManagerInterface $entityManager;

    use RefreshDatabaseTrait;
    protected function setUp(): void
    {
        $this->client = $this->createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        $random = rand(0, 10000);

        $user = new User();
        $user->setEmail($random.'info@mateuszlichwiarz.com');
        $user->setPassword('mateuszlichwiarz'.$random);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $apiToken = new ApiToken();
        $apiToken->setToken(self::API_TOKEN);
        $apiToken->setUserOwner($user);
        $this->entityManager->persist($apiToken);
        $this->entityManager->flush();
    }

    public function testGetCollection(): void
    {
        $response = $this->client->request('GET', '/api/products', [
            'headers' => ['x-api-token' => self::API_TOKEN]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertResponseHeaderSame(
            'content-type', 'application/ld+json; charset=utf-8'
        );

        $this->assertJsonContains([
            '@context'         => '/api/contexts/Product',
            '@id'              => '/api/products',
            '@type'            => 'hydra:Collection',
            'hydra:totalItems' => 100,
            'hydra:view'       => [
                '@id'         => '/api/products?page=1',
                '@type'       => 'hydra:PartialCollectionView',
                'hydra:first' => '/api/products?page=1',
                'hydra:last'  => '/api/products?page=20',
                'hydra:next'  => '/api/products?page=2',
            ],
        ]);
        
        $this->assertCount(5, $response->toArray()['hydra:member']);
    }

    public function testPagination(): void
    {
        $this->client->request('GET', '/api/products?page=2', [
            'headers' => ['x-api-token' => self::API_TOKEN]
        ]);

        $this->assertJsonContains([
            'hydra:view' => [
                '@id'            => '/api/products?page=2',
                '@type'          => 'hydra:PartialCollectionView',
                'hydra:first'    => '/api/products?page=1',
                'hydra:last'     => '/api/products?page=20',
                'hydra:previous' => '/api/products?page=1',
                'hydra:next'     => '/api/products?page=3',
            ],
        ]);
    }

    public function testCreateProduct(): void
    {
        $this->client->request('POST', '/api/products', [
            'headers' => ['x-api-token' => self::API_TOKEN],
            'json' => [
                'mpn' => '5794390407',
                'name' => 'A Test Product',
                'description' => 'A Test Description',
                'issueDate' => '1985-07-31T00:00:00+00:00',
                'manufacturer' => '/api/manufacturers/101',
            ]
        ]);
        $this->assertResponseStatusCodeSame(201);

        $this->assertResponseHeaderSame(
            'content-type', 'application/ld+json; charset=utf-8'
        );

        $this->assertJsonContains([
            'mpn'          => '5794390407',
            'name'         => 'A Test Product',
            'description'  => 'A Test Description',
            'issueDate'    => '1985-07-31T00:00:00+00:00']);

    }

    public function testUpdateProduct(): void
    {
        $this->client->request('PUT', '/api/products/1002', [
            'headers' => ['x-api-token' => self::API_TOKEN],
            'json' => [
                'description' => 'An updated description',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id'        => '/api/products/1002',
            'description' => 'An updated description',
        ]);
    }

}