<?php namespace TourChannel\Parks\Traits;

use DateTime;
use TourChannel\Parks\Enum\CategoryEnum;
use TourChannel\Parks\Enum\ParksEnum;
use TourChannel\Parks\Enum\TicketsEnum;

/**
 * Trait Tickets
 * @package TourChannel\Parks\Traits
 */
trait Tickets
{
    /**
     * Regra de idades do parque
     * @var array
     */
    protected $rules_category = [
        // Categorias de idade Snowland
        ParksEnum::SNOWLAND => [
            CategoryEnum::CRIANCA => '($age >= 4 && $age <= 11)',
            CategoryEnum::ADULTO => '($age >= 12 && $age <= 59)',
            CategoryEnum::SENIOR => '($age >= 60)'
        ],
        // Categorias de idade beto carrero
        ParksEnum::BETO_CARRERO => [
            CategoryEnum::CRIANCA => '($age >= 4 && $age <= 9)',
            CategoryEnum::ADULTO => '($age >= 10 && $age <= 59)',
            CategoryEnum::SENIOR => '($age >= 60)'
        ]
    ];

    /**
     * Adiciona uma pessoa ao voucher
     * @param array $data
     * @param string $type_ticket
     * @return $this
     */
    public function addTicketPerson(array $data, $type_ticket = TicketsEnum::TICKETS)
    {
        // Recupera a categoria da pessoa
        $category = $this->getCategoryPerson($data['birthdate']);

        // Verifica se é necessário enviar pela categoria de idade
        if($category != null) {

            // Se é Snowland Nigth com Buffet
            if($type_ticket == TicketsEnum::DINNERS) $data['buffet'] = false;

            // Combine array
            $ticket = array_merge($data, $category);

            // Add person in tickets
            $this->payload['vouchers'][$type_ticket][$category['category']][] = $ticket;
        }

        return $this;
    }

    /**
     * Retorna a categoria e idade do viajante
     * @param $birthdate
     * @return array|null
     */
    private function getCategoryPerson($birthdate)
    {
        // Recupera a data de nascimento em formato ISO
        $birthdate = $this->getBirthDate($birthdate);

        // Calculo da idade do viajante usodo pelo eval
        $age = $birthdate->diff(new DateTime())->y;

        // Aplica a regra de idade do parque
        foreach ($this->rules_category[self::PARK] as $category => $rule) {
            if(eval("return $rule;")) {
                return [
                    'category' => $category,
                    'birthdate' => $birthdate->format('Y-m-d')
                ];
            }
        }

        return null;
    }

    /**
     * Retorna o nascimento em DateTime
     * @param $birthdate
     * @return DateTime
     */
    private function getBirthDate($birthdate)
    {
        // Explode quando a data for brasileira
        $date_br = explode("/", $birthdate);

        // Verifica se está em formato PT
        if(sizeof($date_br) > 1) {
            return new DateTime( "{$date_br[2]}-{$date_br[1]}-$date_br[0]");
        }

        // Retorna DateTime em ISO
        return new DateTime($birthdate);
    }
}