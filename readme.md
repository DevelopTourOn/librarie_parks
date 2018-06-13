![Logo TourOn](https://www.touron.com.br/modules/site/img/touron.svg  =100x)

# TourChannel / Parks / TourOn

Pacote de integração com API de parques do TourChannel

## Instalação Global

1. Instale a biblioteca: `composer require tourchannel/parks`

### Configuração usando Laravel 5

1. Copie arquivo `vendor\tourchannel\parks\resources\parques.php` e cole dentro da pasta `config`
3. Configure o `user` e `password` da sua aplicação

### Configuração sem Laravel

1. Crie uma pasta chamada `parks-config` no diretório raiz da aplicação
2. Copie o arquivo `vendor\tourchannel\parks\resources\parques-config.php` e cole dentro da pasta que foi criada *(parks-config)*
3. Abra o arquivo copiado *(parques-config.php)* e configure o `user` e `password` da sua aplicação

## Como utilizar a biblioteca

Crie uma classe em sua aplicação chamada `ParksTourChannel` ou dê o nome de sua preferencia
no método `__construct` é necessário passar as configurações da aplicação, veja o exemplo abaixo:

```php
<?php

use TourChannel\Parks\TourChannelParks;

/**
 * Class Example
 */
class Example
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
        TourChannelParks::setConfig(config('parques'));
        $this->touchannel_parks = new TourChannelParks();
    }
}
```