# TourChannel - TourOn - Parks 

Pacote de integração com API de parques do TourChannel

## Lista de instruções
- [Instalação da biblioteca](#instalação-global)
- [Configuração usando Laravel 5](#configuração-usando-laravel-5)
- [Configuração sem laravel](#configuração-sem-laravel)
- [Testando a biblioteca](#testando-a-biblioteca)
- [Changelog](#changelog)

## Instalação Global

Instale a biblioteca: `composer require tourchannel/parks`

## Configuração usando Laravel 5

Adicione em seu `.env` o trecho abaixo e altere com os seus dados de acesso

```text
## DADOS DE ACESSO API PARQUES
TOURCHANNEL_PARKS_USER=usuario
TOURCHANNEL_PARKS_PASSWORD=senha_usuario
```

## Configuração sem Laravel

1. Crie uma pasta chamada `parks-config` no diretório raiz da aplicação
2. Crie um arquivo chamado `cache-parques.txt` dentro dessa pasta
3. Copie o arquivo `vendor\tourchannel\parks\resources\parques-config.php` e cole dentro da pasta que foi criada
4. Abra o arquivo copiado e configure o `user` e `password` da sua aplicação
5. Você deve passar a configuração no método `TourChannelParks::setConfig(array $config)` exemplo abaixo:
6. Caso possua alguma dúvida olhe o arquivo de exemplo em `vendor\tourchannel\parks\resources\Example.php`

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
    
    /**
     * Retorna os parques disponívies para o usuário
     * @return mixed|object
     * @throws Exception
     */
    public function getParks()
    {
        return $this->touchannel_parks->getParksAvailable();
    }
}
```

## Exemplos de utilização

Para ver os métodos disponíveis e de como usá-los

Olhe o arquivo `vendor\tourchannel\parks\resources\Example.php`

## Testando a biblioteca
 
 - **USANDO LARAVEL 5**

```php
$parks = new TourChannelParks();

dd($parks->getParksAvailable());
```

 - **SEM LARAVEL**
 
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

### *v1.1.2 - (04 Julho 2018)*
- Adicionado método para excluir o voucher `` $this->deleteVoucher($order_id) ``
- Adicionado método para alterar a data de utilização `` $this->editVoucherDate($order_id, DateTime $new_date) ``
- Adicionado Enum de dias de antencipação para cada Parque Cadastrado

### *v1.1.1 - (19 Junho 2018)*

- Adicionado certificado SSL para versões antigas do PHP
- Ajustado caminho do arquivo de configuração sem Laravel
- Adicionado passo para criar arquivo de cache no Readme 

### *v1.1.0 - (14 Junho 2018)*

- Adicionado suporte a configuração no `.env` quando for Laravel 

### *v1.0.0 - (13 Junho 2018)*

- Criação e configuração da bilbioteca 