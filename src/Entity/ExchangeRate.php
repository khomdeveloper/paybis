<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ExchangeRate
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\ExchangeRateRepository")
 *
 *  @ORM\Table(name="rate_source")
 */
class ExchangeRate
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="integer")
     */
    public $source_id;

    /**
     * @ORM\Column(type="string")
     */
    public $currency;

    /**
     * @ORM\Column(type="integer")
     */
    public $date;

    /**
     * @ORM\Column(type="float")
     */
    public $rate;

}