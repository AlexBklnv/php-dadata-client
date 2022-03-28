<?php

declare(strict_types=1);

namespace PhpDaData;

use DateTime;
use PhpDaData\Enums\ProfileMethodsEnum;

/**
 * API информации из личного кабинета.
 *
 * @author AlexBklnv <alexbklnv@yandex.ru>
 */
class DaDataProfile
{
    private Client $client;
    
    public function __construct(string $token, ?string $secret = null)
    {
        $this->client = new Client($token, $secret);
    }
    
    /**
     * Даты актуальности справочников.
     * Возвращает даты актуальности справочников (ФИАС, ЕГРЮЛ, банки и другие).
     *
     * @return array
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     * @throws \JsonException
     * @link https://dadata.ru/api/version/
     */
    public function getRelevance(): array
    {
        return $this->client->get(ProfileMethodsEnum::RELEVANCE);
    }
    
    /**
     * Статистика использования.
     * Возвращает агрегированную статистику за конкретный день по каждому из сервисов: стандартизация, подсказки, поиск дублей.
     *
     * @param null|string  $date  Дата формата Y-m-d
     *
     * @return array
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     * @throws \JsonException
     * @link https://dadata.ru/api/stat/
     */
    public function getStat(?string $date = null): array
    {
        if (!$date) {
            $date = (new DateTime())->format("Y-m-d");
        }
        return $this->client->get(ProfileMethodsEnum::USER_STATISTIC, ['date' => $date]);
    }
    
    /**
     * Баланс пользователя.
     * Возвращает текущий баланс вашего счета.
     *
     * @return array
     * @throws \PhpDaData\Exceptions\DaDataRequestException
     * @throws \JsonException
     * @link https://dadata.ru/api/balance/
     */
    public function getBalance(): array
    {
        return $this->client->get(ProfileMethodsEnum::BALANCE);
    }
}