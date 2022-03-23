<?php

declare(strict_types=1);

namespace PhpDaData\Enums;

/**
 * Методы работы с личным кабинетом
 *
 * @author AlexBklnv <alexbklnv@yandex.ru>
 */
class ProfileMethodsEnum
{
    /**
     * @var string Возвращает даты актуальности справочников (ФИАС, ЕГРЮЛ, банки и другие)
     */
    public const RELEVANCE = 'https://dadata.ru/api/v2/version';
    /**
     * @var string Статистика использования
     */
    public const USER_STATISTIC = 'https://dadata.ru/api/v2/stat/daily';
    /**
     * @var string Баланс пользователя
     */
    public const BALANCE = 'https://dadata.ru/api/v2/profile/balance';
}