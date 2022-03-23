<?php

declare(strict_types=1);

namespace PhpDaData\Enums;

/**
 * Методы работы с адресами
 *
 * @author AlexBklnv <alexbklnv@yandex.ru>
 */
class AddressMethodsEnum
{
    /**
     * @var string Разбор адреса из строки («стандартизация») / Геокодирование (координаты по адресу)
     */
    public const CLEAN_ADDRESS = 'https://cleaner.dadata.ru/api/v1/clean/address';
    
    /**
     * @var string Автодополнение при вводе («подсказки»)
     */
    public const SUGGEST_ADDRESS = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address';
    
    /**
     * @var string Обратное геокодирование
     */
    public const SUGGEST_GEO_LOCATE_ADDRESS = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address';
    
    /**
     * @var string Город по IP-адресу
     */
    public const SUGGEST_IP_ADDRESS = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address';
    
    /**
     * @var string Адрес по коду КЛАДР или ФИАС
     */
    public const SUGGEST_FIND_BY_CODE = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/address';
    
    /**
     * @var string Кадастровый номер
     */
    public const SUGGEST_FIND_BY_CADASTRE = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/cadastre';
    
    /**
     * @var string Ближайшее почтовое отделение
     */
    public const SUGGEST_POST_UNIT = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/postal_unit';
    
    /**
     * @var string Страны
     */
    public const SUGGEST_COUNTRY = 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/country';
}