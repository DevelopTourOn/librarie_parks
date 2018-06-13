<?php namespace TourChannel\Parks\Enum;

/**
 * Class WebhookEventType
 * @package TourChannel\Parks\Enum
 */
abstract class WebhookEventType
{
    /** @var string */
    const VOUCHER_SUCCESS = 'voucher_success';

    /** @var string */
    const VOUCHER_ERROR = 'voucher_error';
}
