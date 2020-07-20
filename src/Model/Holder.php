<?php


namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Holder
 * @package App\Model
 */


class Holder
{

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected  $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Choice({"Individual", "Corporate"})
     */
    protected $type;

    /**
     * @var Address
     * @Assert\Valid()
     */
    protected $address;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Holder
     */
    public function setName(string $name): Holder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Holder
     */
    public function setType(string $type): Holder
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Holder
     */
    public function setAddress(Address $address): Holder
    {
        $this->address = $address;
        return $this;
    }

}