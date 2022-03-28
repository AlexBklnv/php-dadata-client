<?php

declare(strict_types=1);

namespace PhpDaData;

use PhpDaData\Exceptions\DaDataRequestException;
use RuntimeException;

/**
 * Http client
 *
 * @author AlexBklnv <alexbklnv@yandex.ru>
 */
final class Client
{
    /**
     * @var string API-ключ
     */
    private string $token;
    
    /**
     * @var null|string Секретный ключ
     */
    private ?string $secret;
    
    /**
     * @param string  $token
     * @param null|string  $secret
     */
    public function __construct(string $token, ?string $secret = null)
    {
        $this->token = $token;
        $this->secret = $secret;
    }
    
    /**
     * @param string  $url
     * @param array  $query
     *
     * @return array
     * @throws DaDataRequestException
     * @throws \JsonException
     */
    public function get(string $url, array $query = []): array
    {
        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }
        return $this->call($url);
    }
    
    /**
     * @param string  $url
     * @param array|null  $data
     *
     * @return array
     * @throws DaDataRequestException
     * @throws \JsonException
     */
    public function post(string $url, ?array $data): array
    {
        return $this->call($url, ['body' => $data]);
    }
    
    /**
     * @throws DaDataRequestException
     * @throws \JsonException
     */
    private function call(string $url, ?array $options = null): array
    {
        $curl = curl_init($url);
        if (!$curl) {
            throw new RuntimeException('curl initialization error');
        }
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "Authorization: Token {$this->token}",
        ];
        
        if (!empty($this->secret)) {
            $headers[] = "X-Secret: {$this->secret}";
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        if (isset($options['body'])) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($options['body'], JSON_THROW_ON_ERROR));
        }
        
        $result = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        $result = json_decode((string)$result, true, 512, JSON_THROW_ON_ERROR);
        
        if (empty($result)) {
            throw new RuntimeException('Empty result');
        }
        
        $this->ensureRequestWithoutErrorByStatusCode($httpStatus, $result);
        
        return $result;
    }
    
    /**
     * Обработка возвращаемых кодов, что результат без ошибок
     *
     * @param null|array  $result  Результат запрос
     * @param int  $status  Статус код запроса
     *
     * @return void
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     */
    private function ensureRequestWithoutErrorByStatusCode(int $status, ?array $result = null): void
    {
        if ($status === 200) {
            return;
        }
        if (isset($result['message'])) {
            throw new DaDataRequestException($result['message'], $status);
        }
        
        switch ($status) {
            case 400:
                throw new RuntimeException('Incorrect request (invalid JSON or XML)');
            case 401:
                throw new RuntimeException('Missing API key');
            case 403:
                throw new RuntimeException('Incorrect API key');
            case 405:
                throw new RuntimeException('Request method must be POST');
            case 413:
                throw new RuntimeException('You push the limits of suggestions');
            case 429:
                throw new RuntimeException('Too many requests per second or new connections per minute');
            case 500:
                throw new RuntimeException('Server internal error');
        }
        
        throw new DaDataRequestException($result['message'] ?? 'Unexpected error', $status);
    }
}