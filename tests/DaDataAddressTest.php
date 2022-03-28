<?php

use PhpDaData\DaDataAddress;
use PHPUnit\Framework\TestCase;

class DaDataAddressTest extends TestCase
{
    private DaDataAddress $service;
    
    protected function setUp(): void
    {
        parent::setUp();
        $token = $_ENV['DADATA_TOKEN'];
        $secret = $_ENV['DADATA_SECRET'];
        $this->service = new DaDataAddress($token, $secret);
    }
    
    /**
     * Просто проверим основные типы запросов
     * @test
     * @return void
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function addresses(): void
    {
        $result = $this->service->cleanAddress('мск сухонска 11/-89');
        self::assertNotNull($result[0]['source'] ?? null);
        
        $result = $this->service->suggestAddress('г Москва, ул Хабаровская');
        self::assertNotEmpty($result['suggestions']);
        
        $result = $this->service->iplocate('2.93.1.0');
        self::assertTrue(isset($result['location']));
    }
}