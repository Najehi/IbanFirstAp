<?php


namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Address
 * @package App\Model
 */


class Address
{
    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $postCode;

    /**
     * @var string
     */
    protected $province;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Country()
     */
    protected $country;

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet(string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     * @return Address
     */
    public function setPostCode(string $postCode): Address
    {
        $this->postCode = $postCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvince(): string
    {
        return $this->province;
    }

    /**
     * @param string $province
     * @return Address
     */
    public function setProvince(string $province): Address
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Address
     */
    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

}