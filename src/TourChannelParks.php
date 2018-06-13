<?php namespace TourChannel\Parks;

use TourChannel\Parks\Enum\HttpEnum;
use TourChannel\Parks\Enum\StatusVoucher;
use TourChannel\Parks\Parks\BetoCarrero;
use TourChannel\Parks\Parks\Snowland;
use TourChannel\Parks\Service\Authentication;
use TourChannel\Parks\Service\RequestConnect;

/**
 * Class TourChannelParks
 * @package TourChannel\Parks
 */
class TourChannelParks
{
    /**
     * URl para recuperar os parques disponiveis
     */
    const PATH_PARKS_AVAILABLE = "/parks";

    /**
     * URL para pesquisa do voucher
     * @var string
     */
    private $PATH_VOUCHER = "/voucher/{id_voucher}";

    /**
     * URL para impressão do voucher
     * @var string
     */
    static $URL_VOUCHER = RequestConnect::URL_BASE_API;

    /**
     * Keys of array config
     * @var array
     */
    private static $RULES_CONFIG = [
        'user', 'password', 'file_cache_token'
    ];

    /**
     * Save on GLOBAL config to access API
     * @param array $data
     * @throws \Exception
     */
    static public function setConfig(array $data)
    {
        // Combine array config
        $config = array_combine(self::$RULES_CONFIG, $data);

        // Validate if empty
        foreach (self::$RULES_CONFIG as $rule) {
            if($config[$rule] == "") throw new \Exception("$rule is required");
        }

        // Save Global config
        $GLOBALS[Authentication::GLOBAL_KEY] = $config;
    }

    /**
     * Recupera os parques disponiveis na API
     * @return mixed|object
     * @throws \Exception
     */
    public function getParksAvailable()
    {
        $touchannel_parks = new RequestConnect();

        return $touchannel_parks->connect_api(self::PATH_PARKS_AVAILABLE, HttpEnum::METHOD_GET);
    }

    /**
     * Consulta o Voucher na API
     * @param $voucher_id
     * @return mixed|object
     * @throws \Exception
     */
    public function getVoucher($voucher_id)
    {
        $touchannel_parks = new RequestConnect();

        // Configura o id do voucher para pesquisa
        $this->PATH_VOUCHER = str_replace("{id_voucher}", $voucher_id, $this->PATH_VOUCHER);

        // Recupera os dados do voucher
        $voucher = $touchannel_parks->connect_api($this->PATH_VOUCHER, HttpEnum::METHOD_GET);

        // Quando o voucher está pronto
        if($voucher->status == StatusVoucher::PRONTO) {

            // URL de impressão do voucher sem a BASE URL
            $voucher->voucher_url = str_replace(RequestConnect::URL_BASE_API, "", $voucher->voucher_url);
        }

        return $voucher;
    }

    /**
     * Parque Snowland
     * @return Snowland
     */
    public function snowland()
    {
        return new Snowland();
    }

    /**
     * Parque Beto Carrero
     * @return BetoCarrero
     */
    public function beto_carrero()
    {
        return new BetoCarrero();
    }
}