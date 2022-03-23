## Клиент для работы с API DaData
![Packagist Version](https://img.shields.io/packagist/v/alexbklnv/php-dadata-client?color=blue&label=version)
![License](https://img.shields.io/github/license/alexbklnv/php-dadata-client)
![Packagist Downloads](https://img.shields.io/packagist/dm/alexbklnv/php-dadata-client)
![Packagist Downloads](https://img.shields.io/packagist/dt/alexbklnv/php-dadata-client)


## :scroll: **Installation**
Установка пакета через composer:
```
composer require alexbklnv/php-dadata-client
```

## :scroll: **Usage**

1. Работа с адресами и геокоординатами.
+ [Разбор адреса из строки («стандартизация»)](#CleanAddress)
+ [Автодополнение адреса при вводе («подсказки»)](#SuggestAddress)
+ [Геокодирование (координаты по адресу)](#geocode)
+ [Обратное геокодирование (адрес по координатам)](#geolocate)
+ [Город по IP-адресу](#iplocate)
+ [Поиск адреса по коду КЛАДР или ФИАС](#findAddress)
+ [Кадастровый номер](#cadastre)
+ [Ближайшее почтовое отделение](#postalUnit)
+ [Поиск стран](#country)

2. Работа с профилем пользователя
+ [Проверка баланса](#Balance)
+ [Получение статистики](#Stat)
+ [Справка по актуальности справочников](#Relevance)

## Работа с почтовыми адресами и геокоординатами.
#### <a name="CleanAddress"></a>Разбор адреса из строки («стандартизация») [(Документация)](https://dadata.ru/api/clean/address/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->cleanAddress('мск сухонска 11/-89');
```

#### <a name="SuggestAddress"></a>Подсказки по адресам [(Документация)](https://dadata.ru/api/suggest/address/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->suggestionsAddress('москва хабар');
```

#### <a name="geocode"></a>Геокодирование (координаты по адресу) [(Документация)](https://dadata.ru/api/geocode/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->geocodeAddress('москва сухонская 11');
```

#### <a name="geolocate"></a>Обратное геокодирование (адрес по координатам) [(Документация)](https://dadata.ru/api/geolocate/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->geolocate('55.87', '37.653');
```

#### <a name="iplocate"></a>Город по IP-адресу [(Документация)](https://dadata.ru/api/iplocate/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->iplocate('46.226.227.20');
```

#### <a name="findAddress"></a>Поиск адреса по коду КЛАДР или ФИАС [(Документация)](https://dadata.ru/api/find-address/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->findByCode('9120b43f-2fae-4838-a144-85e43c2bfb29');
```

#### <a name="cadastre"></a>Кадастровый номер по КЛАДР или ФИАС [(Документация)](https://dadata.ru/api/cadastre/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->findByCadastre('9120b43f-2fae-4838-a144-85e43c2bfb29');
```

#### <a name="postalUnit"></a>Поиск отделений Почта России [(Документация)](https://dadata.ru/api/suggest/postal_unit/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->findPostUnit('дежнева 2а');
```

#### <a name="country"></a>Поиск стран [(Документация)](https://dadata.ru/api/suggest/country/)

```php
$dadata = new DaDataAddress($token, $secret);
$result = $dadata->suggestCountry('та');
```

## Работа с профилем пользователя
#### <a name="Balance"></a>Проверка баланса [(Документация)](https://dadata.ru/api/balance/)

```php
$dadata = new DaDataProfile($token, $secret);
$result = $dadata->getBalance();
```

#### <a name="Stat"></a>Получение статистики [(Документация)](https://dadata.ru/api/stat/)

На текущий день:

```php
$dadata = new DaDataProfile($token, $secret);
$result = $dadata->getStat();
```
На любую другую дату:

```php
$dadata = new DaDataProfile($token, $secret);
$result = $dadata->getStat('2019-11-01');
```


#### <a name="Relevance"></a>Справка по актуальности справочников [(Документация)](https://dadata.ru/api/version/)

```php
$dadata = new DaDataProfile($token, $secret);
$result = $dadata->getRelevance();
```