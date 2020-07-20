<?php


namespace App\Serializer\PropertyInfo\Extractor;

use App\Model\Holder;
use App\Model\Wallet;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\PropertyInfo\Type;

/**
 * Class CustomModelExtractor
 * @package App\Serializer\PropertyInfo\Extractor
 */

class CustomModelExtractor implements PropertyTypeExtractorInterface
{
    /**
     * @var ReflectionExtractor
     */
    private $reflectionExtractor;

    /**
     * CustomModelExtractor constructor.
     */
    public function __construct()
    {
        $this->reflectionExtractor = new ReflectionExtractor();
    }

    /**
     * @param string $class
     * @param string $property
     * @param array  $context
     *
     * @return array|Type[]|null
     */
    public function getTypes($class, $property, array $context = array())
    {
        if (\is_a($class, Wallet::class, true) && 'holder' === $property) {
            return [
                new Type(Type::BUILTIN_TYPE_OBJECT, true, Holder::class)
            ];
        }

        return $this->reflectionExtractor->getTypes($class, $property, $context);
    }

}