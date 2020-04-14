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
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $url;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;


    /**
     * @ORM\Column(type="string")
     */
    public $method;

    /**
     * @ORM\Column(type="string")
     */
    public $parameters;


    /**
     * @ORM\Column(type="float")
     */
    public $frequency;

    /**
     * @ORM\Column(type="string")
     */
    public $class;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @ORM\Column(type="integer")
     */
    public $down_counter;


    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getName()
    {
        return $this->name;
    }

}