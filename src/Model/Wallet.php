<?php


namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Wallet
 * @package App\Model
 */

class Wallet
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Currency()
     */
    protected $currency;

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var Holder
     * @Assert\Valid()
     */
    protected $holder;

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Wallet
     */
    public function setCurrency(string $currency): Wallet
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return Wallet
     */
    public function setTag(string $tag): Wallet
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return Holder
     */
    public function getHolder(): Holder
    {
        return $this->holder;
    }

    /**
     * @param Holder $holder
     * @return Wallet
     */
    public function setHolder(Holder $holder): Wallet
    {
        $this->holder = $holder;
        return $this;
    }
}