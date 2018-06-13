<?php namespace TourChannel\Parks\Traits;

/**
 * Trait Customer
 * @package TourChannel\Parks\Traits
 */
trait Customer
{
    /**
     * Nome do cliente
     * @param string $name
     * @return $this
     */
    public function setCustomerName($name)
    {
        $this->payload['name'] = $name;

        return $this;
    }

    /**
     * Email do cliente
     * @param string $email
     * @return $this
     */
    public function setCustomerEmail($email)
    {
        $this->payload['email'] = $email;

        return $this;
    }

    /**
     * Documento do cliente
     * @param $document
     * @return $this
     */
    public function setCustomerDocument($document)
    {
        $document = preg_replace("/[^0-9]/", "", $document);

        $this->payload['cpf'] = $document;
        $this->payload['rg'] = $document;

        return $this;
    }

    /**
     * Configura os telefones do cliente devem conter DDD
     * @param array $phones
     * @return $this
     */
    public function setCustomerPhone(array $phones)
    {
        $mobile_phone = preg_replace("/[^0-9]/", "", $phones[0]);
        $home_phone = (! isset($phones[1]) || $phones[1] == "") ? $mobile_phone : preg_replace("/[^0-9]/", "", $phones[1]);

        // Coloca os telefones com mascara
        $this->payload['mobile_number'] = $this->mask($mobile_phone, "(##) #########");
        $this->payload['residential_number'] = $this->mask($home_phone, "(##) #########");

        return $this;
    }

    /**
     * Adiciona mascaras dinamicamente na string
     * @param $val
     * @param $mask
     * @return string
     */
    private function mask($val, $mask){

        $maskared = ''; $k = 0;

        for($i = 0; $i <= strlen($mask) -1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }

        return $maskared;
    }
}