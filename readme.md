# TourChannel - TourOn - Parks 

Pacote de integração com API de parques do TourChannel

## Lista de instruções
- [Instalação da biblioteca](#instalação-global)
- [Configuração usando Laravel 5](#configuração-usando-laravel-5)
- [Configuração sem laravel](#configuração-sem-laravel)
- [Testando a biblioteca](#testando-a-biblioteca)
- [Parque Snowland](#parque-snowland)
- [Changelog](#changelog)

## Instalação Global

Instale a biblioteca: `composer require tourchannel/parks`

## Configuração usando Laravel 5

1. Copie arquivo `vendor\tourchannel\parks\resources\parques.php` e cole dentro da pasta `config`
2. Configure o `user` e `password` da sua aplicação
3. Você deve passar a configuração no método `TourChannelParks::setConfig(array $config)` exemplo abaixo:
4. Caso possua alguma dúvida olhe o arquivo de exemplo em `vendor\tourchannel\parks\resources\Example.php`

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
4. Caso possua alguma dúvida olhe o arquivo de exemplo em `vendor\tourchannel\parks\resources\Example.php`

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

## Testando a biblioteca

Para testar se a configuração está correta adicione o método abaixo em sua classe:

```php
/**
 * Retorna os parques disponívies para o usuário
 * @return mixed|object
 * @throws Exception
 */
public function getParks()
{
    return $this->touchannel_parks->getParksAvailable();
}
```

Agora debug o resultado:
 
 **USANDO LARAVEL 5**:

```php
$parks = new ParkService(); // Nome da sua classe

dd($parks->getParks());
```

 **SEM LARAVEL**:
 
```php
$parks = new ParksClass(); // Nome da sua classe

echo "<pre>";

print_r($parks->getParks());

exit();
```

Se tudo estiver correto você deve ter um retorno parecido com este:

```json
[
    {
      "name":"Snowland",
      "identifier":"snowland"
    },
    {
      "name":"Beto Carrero",
      "identifier":"beto_carrero"
    }
]
```

## Changelog

Lista de mudanças, melhorias e correções de bugs.

### v1.0.0 - *(13 Junho 2018)*

- Criação e configuração da bilbioteca 