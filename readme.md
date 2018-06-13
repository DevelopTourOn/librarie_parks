# TourChannel - TourOn - Parks 

Pacote de integração com API de parques do TourChannel

## Lista de instruções
- [Instalação da biblioteca](#instalação-global)
- [Configuração usando Laravel 5](#configuração-usando-laravel-5)
- [Configuração sem laravel](#configuração-sem-laravel)
- [Changelog](#changelog)

## Instalação Global

1. Instale a biblioteca: `composer require tourchannel/parks`

## Configuração usando Laravel 5

1. Copie arquivo `vendor\tourchannel\parks\resources\parques.php` e cole dentro da pasta `config`
2. Configure o `user` e `password` da sua aplicação
3. Você deve passar a configuração no método `TourChannelParks::setConfig(array $config)` exemplo abaixo:

```php
<?php namespace App\Services;

use TourChannel\Parks\TourChannelParks;

/**
 * Class Example
 */
class ParkService
{
    /**
     * Bilioteca API parques
     * @var TourChannelParks
     */
    private $touchannel_parks;

    /**
     * Configuração da API
     * Example constructor.
     */
    public function __construct()
    {
        // Array de configuração da aplicação
        TourChannelParks::setConfig(config('parques'));
        $this->touchannel_parks = new TourChannelParks();
    }
}
```

## Configuração sem Laravel

1. Crie uma pasta chamada `parks-config` no diretório raiz da aplicação
2. Copie o arquivo `vendor\tourchannel\parks\resources\parques-config.php` e cole dentro da pasta que foi criada
3. Abra o arquivo copiado e configure o `user` e `password` da sua aplicação
3. Você deve passar a configuração no método `TourChannelParks::setConfig(array $config)` exemplo abaixo:

```php
<?php

use TourChannel\Parks\TourChannelParks;

/**
 * Class Example
 */
class ParksClass
{
    /**
     * Bilioteca API parques
     * @var TourChannelParks
     */
    private $touchannel_parks;

    /**
     * Configuração da API
     * Example constructor.
     * @throws Exception
     */
    public function __construct()
    {
        // PATH do arquivo de configuração criado
        $config = include_once realpath(__DIR__ . "../../parques-config.php");
        // Array de configuração da aplicação
        TourChannelParks::setConfig($config);
        $this->touchannel_parks = new TourChannelParks();
    }
}
```

## Changelog

## v1.0.0 - *(13 Junho 2018)*

- Criação e configuração da bilbioteca 