<?php namespace TourChannel\Parks\Traits;

use DateTime;
use TourChannel\Parks\Enum\HttpEnum;
use TourChannel\Parks\Enum\StatusVoucher;
use TourChannel\Parks\Service\RequestConnect;

/**
 * Trait Voucher
 * @package TourChannel\Parks\Traits
 */
trait Voucher
{
    /**
     * URL para pesquisa do voucher
     * @var string
     */
    private $PATH_VOUCHER = "/voucher/{id_voucher}";

    /**
     * URL para deletar o voucher na API
     * @var string
     */
    private $PATH_DELETE_VOUCHER = "/order/delete";

    /**
     * URL para editar o voucher na API
     * @var string
     */
    private $PATH_EDIT_VOUCHER = "/order/edit";

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
     * Deleta order na API
     * @param $order_id
     * @return object
     * @throws \Exception
     */
    public function deleteVoucher($order_id)
    {
        $touchannel_parks = new RequestConnect();

        // Delete voucher on API
        $result = $touchannel_parks->connect_api($this->PATH_DELETE_VOUCHER, HttpEnum::METHOD_DELETE, [
            'order_id' => $order_id
        ]);

        // Order id
        $result->order = $order_id;

        // Result deleted
        $result->deleted = (! (isset($result->status) && $result->status == "error"));

        return $result;
    }

    /**
     * Update voucher date
     * @param $order_id
     * @param DateTime $new_date
     * @return object
     * @throws \Exception
     */
    public function editVoucherDate($order_id, DateTime $new_date)
    {
        $touchannel_parks = new RequestConnect();

        // Edit voucher date on API
        $result = $touchannel_parks->connect_api($this->PATH_EDIT_VOUCHER, HttpEnum::METHOD_PUT, [
            'order_id' => $order_id,
            'new_date' => $new_date->format('Y-m-d')
        ]);

        // Order id
        $result->order = $order_id;

        // Result updated
        $result->updated = (! (isset($result->status) && $result->status == "error"));

        return $result;
    }
}