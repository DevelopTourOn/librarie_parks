<?php namespace TourChannel\Parks;

use TourChannel\Parks\Enum\HttpEnum;
use TourChannel\Parks\Enum\StatusVoucher;
use TourChannel\Parks\Parks\BetoCarrero;
use TourChannel\Parks\Parks\Snowland;
use TourChannel\Parks\Service\Authentication;
use TourChannel\Parks\Service\RequestConnect;
use TourChannel\Parks\Traits\Voucher;

/**
 * Class TourChannelParks
 * @package TourChannel\Parks
 */
class TourChannelParks
{
    use Voucher;

    /**
     * URl para recuperar os parques disponiveis
     */
    private $PATH_PARKS_AVAILABLE = "/parks";

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

        return $touchannel_parks->connect_api($this->PATH_PARKS_AVAILABLE, HttpEnum::METHOD_GET);
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