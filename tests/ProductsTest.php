<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class ProductsTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/products');

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
        $response = static::createClient()->request('GET', '/api/products?page=2');

        $this->assertJsonContains([
            'hydra:view'       => [
                '@id'           => '/api/products?page=2',
                '@type'         => 'hydra:PartialCollectionView',
                'hydra:first'   => '/api/products?page=1',
                'hydra:last'    => '/api/products?page=20',
                'hydra:previous' => '/api/products?page=1',
                'hydra:next'    => '/api/products?page=3',
            ],
        ]);
    }

    public function testCreateProduct(): void
    {
        static::createClient()->request('POST', '/api/products', [
            'json' => [
                'mpn'          => '1234',
                'name'         => 'A Test Product',
                'description'  => 'A Test Description',
                'issueDate'    => '2023-07-05T23:29:25.361Z',
                'manufacturer' => '/api/manufacturers/1',
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);

        $this->assertResponseHeaderSame(
            'content-type', 'application/ld+json; charset=utf-8'
        );

        $this->assertJsonContains([
            'mpn'          => '1234',
            'name'         => 'A Test Product',
            'description'  => 'A Test Description',
            'issueDate'    => '2023-07-05T23:29:25.361Z']);

    }

}