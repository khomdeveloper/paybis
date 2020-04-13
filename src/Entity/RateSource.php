<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="rate_source")
 */
class RateSource
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(startegy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $url;

    /**
     * @ORM\Column(type="string")
     */
    public $method;

    /**
     * @ORM\Column(type="string")
     */
    public $parameters;


    /**
     * @ORM\Column(type="integer")
     */
    public $frequency;


    /**
     * @ORM\Column(type="string")
     */
    public $active;



}