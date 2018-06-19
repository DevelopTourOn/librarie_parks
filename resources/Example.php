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
        /** Caso a aplicação não esteja em laravel descomente a linha abaixo */
        //$config = include realpath(__DIR__ . "/../../parques-config.php");
        //TourChannelParks::setConfig($config);

        $this->touchannel_parks = new TourChannelParks();
    }

    /**
     * Recupera o voucher
     * @param $id_voucher
     * @return mixed|object
     * @throws Exception
     */
    public function getVoucher($id_voucher)
    {
        return $this->touchannel_parks->getVoucher($id_voucher);
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

    /**
     * Pesquisa os serviços do Snowland disponiveis na data
     * @param DateTime $date
     * @return mixed|object
     * @throws Exception
     */
    public function getProductsByDateSnowland(DateTime $date)
    {
        return $this->touchannel_parks->snowland()->getProductsByDate($date);
    }

    /**
     * Pesquisa os serviços do Beto Carrero disponiveis na data
     * @param DateTime $date
     * @return mixed|object
     * @throws Exception
     */
    public function getProductsByDateBeto(DateTime $date)
    {
        return $this->touchannel_parks->beto_carrero()->getProductsByDate($date);
    }

    /**
     * Recurso para enviar/gerar vouchers do Snowland
     * @param array $cliente
     * @param DateTime $data_utilizacao
     * @param array $viajantes
     * @return mixed|object
     * @throws Exception
     */
    public function voucherSnowland(array $cliente, array $viajantes, DateTime $data_utilizacao)
    {
        // Parque Snowland
        $parque_snowland = $this->touchannel_parks->snowland();

        // Dados do comprador do ticket
        $parque_snowland->setCustomerName($cliente['nome'])
            ->setCustomerDocument($cliente['documento'])
            ->setCustomerPhone([$cliente['telefone']])
            ->setCustomerEmail($cliente['email']);

        // Data de utilização do voucher em DateTime
        $parque_snowland->setVoucherDate($data_utilizacao);

        // Adiciona os viajantes no ticket
        foreach ($viajantes as $viajante) {
            // A categoria do viajante é calculado automaticamente
            $parque_snowland->addTicketPerson([
                "name" => $viajante['nome'],
                "document" => $viajante['documento'],
                "birthdate" => $viajante['nascimento']
            ]);
        }

        return $parque_snowland->requestVoucher();
    }

    /**
     * Recurso para enviar/gerar vouchers do Beto Carrero
     * @param array $cliente
     * @param DateTime $data_utilizacao
     * @param array $viajantes
     * @return mixed|object
     * @throws Exception
     */
    public function voucherBetoCarrero(array $cliente, array $viajantes, DateTime $data_utilizacao)
    {
        // Parque Beto Carrero
        $parque_beto = $this->touchannel_parks->beto_carrero();

        // Dados do comprador do ticket
        $parque_beto->setCustomerName($cliente['nome'])
            ->setCustomerDocument($cliente['documento'])
            ->setCustomerPhone([$cliente['telefone']])
            ->setCustomerEmail($cliente['email']);

        // Data de utilização do voucher em DateTime
        $parque_beto->setVoucherDate($data_utilizacao);

        // Adiciona os viajantes no ticket
        foreach ($viajantes as $viajante) {
            // A categoria do viajante é calculado automaticamente
            $parque_beto->addTicketPerson([
                "name" => $viajante['nome'],
                "document" => $viajante['documento'],
                "birthdate" => $viajante['nascimento']
            ]);
        }

        return $parque_beto->requestVoucher();
    }
}