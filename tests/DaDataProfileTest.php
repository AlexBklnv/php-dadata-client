<?php

use PhpDaData\DaDataProfile;
use PHPUnit\Framework\TestCase;

class DaDataProfileTest extends TestCase
{
    private DaDataProfile $service;
    
    protected function setUp(): void
    {
        parent::setUp();
        $token = $_ENV['DADATA_TOKEN'];
        $secret = $_ENV['DADATA_SECRET'];
        $this->service = new DaDataProfile($token, $secret);
    }
    
    /**
     * @test
     * @return void
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function getRelevance(): void
    {
        $result = $this->service->getRelevance();
        self::assertNotNull($result['dadata'] ?? null);
        self::assertNotNull($result['factor'] ?? null);
        self::assertNotNull($result['suggestions'] ?? null);
    }
    
    /**
     * @test
     * @return void
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function getStat(): void
    {
        $result = $this->service->getStat();
        self::assertEquals((new DateTime())->format('Y-m-d'), $result['date'] ?? null);
        self::assertNotNull($result['services'] ?? null);
    }
    
    /**
     * @test
     * @return void
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function getBalance(): void
    {
        $result = $this->service->getBalance();
        self::assertNotNull($result['balance'] ?? null);
    }
}