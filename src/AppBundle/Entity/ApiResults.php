<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiResults
 *
 * @ORM\Table(name="api_results")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApiResultsRepository")
 */
class ApiResults
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="moneyType", type="string", length=255)
     */
    private $moneyType;

    /**
     * @var string
     *
     * @ORM\Column(name="fromThe", type="string", length=255)
     */
    private $fromThe;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=5)
     */
    private $amount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set moneyType
     *
     * @param string $moneyType
     *
     * @return ApiResults
     */
    public function setMoneyType($moneyType)
    {
        $this->moneyType = $moneyType;

        return $this;
    }

    /**
     * Get moneyType
     *
     * @return string
     */
    public function getMoneyType()
    {
        return $this->moneyType;
    }

    /**
     * Set fromThe
     *
     * @param string $fromThe
     *
     * @return ApiResults
     */
    public function setFromThe($fromThe)
    {
        $this->fromThe = $fromThe;

        return $this;
    }

    /**
     * Get fromThe
     *
     * @return string
     */
    public function getFromThe()
    {
        return $this->fromThe;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return ApiResults
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }
}

