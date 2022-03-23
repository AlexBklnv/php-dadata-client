<?php

declare(strict_types=1);

namespace PhpDaData;

use PhpDaData\Enums\AddressMethodsEnum;

/**
 * Клиент API DaData для работы с адресами России.
 *
 * @link https://dadata.ru/api/#address
 * @author AlexBklnv <alexbklnv@yandex.ru>
 */
final class DaDataAddress
{
    private Client $client;
    
    /**
     * @param string  $token  API-ключ
     * @param null|string  $secret  Секретный ключ
     */
    public function __construct(string $token, ?string $secret = null)
    {
        $this->client = new Client($token, $secret);
    }
    
    /**
     * Разбор адреса из строки («стандартизация»)
     * Разбивает адрес из строки по отдельным полям (регион, город, улица, дом, квартира) согласно КЛАДР/ФИАС. Определяет почтовый индекс, часовой пояс,
     * ближайшее метро, координаты, стоимость квартиры и другую информацию об адресе.
     *
     * @param string  $address  Адрес
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/clean/address/
     */
    public function cleanAddress(string $address): array
    {
        return $this->client->post(AddressMethodsEnum::CLEAN_ADDRESS, [$address]);
    }
    
    /**
     * Автодополнение при вводе («подсказки»)
     * Ищет адреса по любой части адреса от региона до квартиры («самара авроры 7 12» → «443017, Самарская обл, г Самара, ул Авроры, д 7, кв 12»).
     * Также ищет по почтовому индексу («105568» → «г Москва, ул Магнитогорская»).
     *
     * @param string  $address  Адрес
     * @param int  $count  Количество результатов (максимум — 20)
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/suggest/address/
     */
    public function suggestAddress(string $address, int $count = 10): array
    {
        return $this->client->post(AddressMethodsEnum::SUGGEST_ADDRESS, ['query' => $address, 'count' => $count]);
    }
    
    /**
     * Геокодирование (координаты по адресу)
     * Определяет координаты адреса (дома, улицы, города)
     *
     * @param string  $address  Адрес
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/geocode/
     */
    public function geocodeAddress(string $address): array
    {
        return $this->client->post(AddressMethodsEnum::CLEAN_ADDRESS, [$address]);
    }
    
    /**
     * Обратное геокодирование (адрес по координатам)
     * Находит ближайшие адреса (дома, улицы, города) по географическим координатам
     *
     * @param string  $lat  Географическая широта
     * @param string  $lon  Географическая долгота
     * @param int  $radiusMeters  Радиус поиска в метрах (максимум – 1000)
     * @param int  $count  Количество результатов (максимум — 20)
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/geolocate/
     */
    public function geolocate(string $lat, string $lon, int $radiusMeters = 100, int $count = 10): array
    {
        return $this->client->get(
            AddressMethodsEnum::SUGGEST_GEO_LOCATE_ADDRESS,
            ['lat' => $lat, 'lon' => $lon, 'radius_meters' => $radiusMeters, 'count' => $count]
        );
    }
    
    /**
     * Город по IP-адресу
     *
     * @param string  $ip
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/iplocate/
     */
    public function iplocate(string $ip): array
    {
        return $this->client->get(AddressMethodsEnum::SUGGEST_IP_ADDRESS, ['ip' => $ip]);
    }
    
    /**
     * Поиск адреса по коду КЛАДР или ФИАС
     *
     * @param string  $code  Код КЛАДР или ФИАС
     * @param int  $count  Количество результатов (максимум — 20)
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/find-address/
     */
    public function findByCode(string $code, int $count = 10): array
    {
        return $this->client->post(AddressMethodsEnum::SUGGEST_FIND_BY_CODE, ['query' => $code, 'count' => $count]);
    }
    
    /**
     * Кадастровый номер по КЛАДР или ФИАС.
     * Находит кадастровый номер дома, квартиры или земельного участка по ФИАС-коду
     *
     * @param string  $code  Код КЛАДР или ФИАС
     * @param int  $count  Количество результатов (максимум — 20)
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/cadastre/
     */
    public function findByCadastre(string $code, int $count = 10): array
    {
        return $this->client->post(AddressMethodsEnum::SUGGEST_FIND_BY_CADASTRE, ['query' => $code, 'count' => $count]);
    }
    
    /**
     * Поиск отделений Почта России
     *
     * @param string  $address
     *
     * @return array
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/suggest/postal_unit/
     */
    public function findPostUnit(string $address): array
    {
        return $this->client->post(AddressMethodsEnum::SUGGEST_POST_UNIT, ['query' => $address]);
    }
    
    /**
     * Поиск стран
     * Справочник стран мира по стандарту ISO 3166
     *
     * @param string  $country
     *
     * @return array
     *
     * @throws \PhpDadata\Exceptions\DaDataRequestException
     * @link https://dadata.ru/api/suggest/country/
     */
    public function suggestCountry(string $country): array
    {
        return $this->client->post(AddressMethodsEnum::SUGGEST_COUNTRY, ['query' => $country]);
    }
}