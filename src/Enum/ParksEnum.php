<?php namespace TourChannel\Parks\Enum;

/**
 * Class Parks
 * @package TourChannel\Parks\Enum
 */
abstract class ParksEnum
{
    /** @var string */
    const SNOWLAND = 'snowland';

    /** @var string */
    const BETO_CARRERO = 'beto_carrero';

    /**
     * Quantidade de dias para antecipação Snowland
     * 0 Dias antes da utilização
     * Gerar 5 minutos após o envio para API
     */
    const DAYS_SNOWLAND = 0;

    /**
     * Quantidade de dias para antecipação Beto Carrero
     * 7 dias antes da utilização
     */
    const DAYS_BETO_CARRERO = 7;
}
