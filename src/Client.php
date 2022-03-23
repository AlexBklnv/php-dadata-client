<?php

declare(strict_types=1);

namespace PhpDaData;

use PhpDadata\Exceptions\DaDataRequestException;
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
     */
    public function post(string $url, ?array $data): array
    {
        return $this->call($url, $data);
    }
    
    /**
     * @throws DaDataRequestException
     */
    private function call(string $url, ?array $options = null)
    {
        $curl = curl_init($url);
        if (!$curl) {
            throw new RuntimeException('curl initialization error');
        }
        
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization' => "Token {$this->token}",
        ];
        
        if (!empty($this->secret)) {
            $headers["X-Secret"] = $this->secret;
        }
        
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        if (isset($options['body'])) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($options['body']));
        }
        
        $result = curl_exec($curl);
        if (empty($result)) {
            throw new RuntimeException('Empty result');
        }
        
        $result = json_decode((string)$result, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Error parsing response: ' . json_last_error_msg());
        }
        
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $this->ensureRequestWithoutErrorByStatusCode($httpStatus, $result);
        
        curl_close($curl);
        
        return $result;
    }
    
    /**
     * Обработка возвращаемых кодов, что результат без ошибок
     *
     * @param int  $status  Статус код запроса
     * @param array  $result  Результат запрос
     *
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     */
    private function ensureRequestWithoutErrorByStatusCode(int $status, array $result): void
    {
        switch ($status) {
            case 200:
                return;
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
            default:
                throw new DaDataRequestException($result['message'] ?? 'Unexpected error', $status);
        }
    }
}