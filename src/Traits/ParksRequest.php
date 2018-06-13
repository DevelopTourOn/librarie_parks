<?php namespace TourChannel\Parks\Traits;

use DateTime;
use TourChannel\Parks\Enum\HttpEnum;
use TourChannel\Parks\Service\RequestConnect;

/**
 * Trait ParksRequest
 * @package TourChannel\Parks\Traits
 */
trait ParksRequest
{
    /**
     * URl para pesquisa de serviços por parque e data
     * @var string
     */
    private $PATH_PRODUCTS = "/products/{park}/{date}";

    /**
     * Configura a data do voucher
     * @param DateTime $date
     */
    public function setVoucherDate(DateTime $date)
    {
        $this->payload['vouchers_date'] = $date->format('Y-m-d');
    }

    /**
     * Pesquisa serviço por parque e data
     * @param $date
     * @return mixed|object
     * @throws \Exception
     */
    public function getProductsByDate(DateTime $date)
    {
        $touchannel_parks = new RequestConnect();

        // Configura o parque de pesquisa
        $this->PATH_PRODUCTS = str_replace("{park}", self::PARK, $this->PATH_PRODUCTS);

        // Configura a data de pesquisa
        $this->PATH_PRODUCTS = str_replace("{date}", $date->format('Y-m-d'), $this->PATH_PRODUCTS);

        return $touchannel_parks->connect_api($this->PATH_PRODUCTS, HttpEnum::METHOD_GET);
    }

    /**
     * Solicita voucher para API
     * @return mixed|object
     * @throws \Exception
     */
    public function requestVoucher()
    {
        $touchannel_parks = new RequestConnect();

        return $touchannel_parks->connect_api(self::_PATH, HttpEnum::METHOD_POST, $this->payload);
    }
}