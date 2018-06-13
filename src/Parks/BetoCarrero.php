<?php namespace TourChannel\Parks\Parks;

use TourChannel\Parks\Enum\ParksEnum;
use TourChannel\Parks\Traits\Customer;
use TourChannel\Parks\Traits\ParksRequest;
use TourChannel\Parks\Traits\Tickets;

/**
 * Class BetoCarrero
 * @package TourChannel\Parks\Parks
 */
class BetoCarrero
{
    use ParksRequest, Customer, Tickets;

    /** PATH da URl na API */
    const _PATH = '/voucher/beto_carrero';

    /** Identificador do parque */
    const PARK = ParksEnum::BETO_CARRERO;

    /**
     * Formatado do array que ira para API
     * @var array
     */
    protected $payload = [];
}