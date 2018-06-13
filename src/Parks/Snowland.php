<?php namespace TourChannel\Parks\Parks;

use TourChannel\Parks\Enum\ParksEnum;
use TourChannel\Parks\Traits\Customer;
use TourChannel\Parks\Traits\ParksRequest;
use TourChannel\Parks\Traits\Tickets;

/**
 * Class Snowland
 * @package TourChannel\Parks\Parks
 */
class Snowland
{
    use ParksRequest, Customer, Tickets;

    /** PATH da URl na API */
    const _PATH = '/voucher/snowland';

    /** Identificador do parque */
    const PARK = ParksEnum::SNOWLAND;

    /**
     * Formatado do array que ira para API
     * @var array
     */
    protected $payload = [
        "vouchers" => []
    ];
}