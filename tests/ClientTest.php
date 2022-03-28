<?php

use PhpDaData\Client;
use PhpDaData\Enums\AddressMethodsEnum;
use PhpDaData\Exceptions\DaDataRequestException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $token;
    
    private $secret;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->token = $_ENV['DADATA_TOKEN'];
        $this->secret = $_ENV['DADATA_SECRET'];
    }
    
    /**
     * @test
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function wrongMethod(): void
    {
        $client = new Client($this->token, $this->secret);
        
        $this->expectException(DaDataRequestException::class);
        $this->expectExceptionCode(405);
        $client->get(AddressMethodsEnum::CLEAN_ADDRESS, ['мск сухонска 11/-89']);
    }
    
    /**
     * @test
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function emptyToken(): void
    {
        $client = new Client('', '');
        $this->expectException(DaDataRequestException::class);
        $this->expectExceptionCode(401);
        $client->get(AddressMethodsEnum::CLEAN_ADDRESS, ['мск сухонска 11/-89']);
    }
    
    /**
     * @test
     * @throws \JsonException
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    public function incorrectToken(): void
    {
        $client = new Client('213', '231');
        $this->expectException(DaDataRequestException::class);
        $this->expectExceptionCode(403);
        $client->get(AddressMethodsEnum::CLEAN_ADDRESS, ['мск сухонска 11/-89']);
    }
}