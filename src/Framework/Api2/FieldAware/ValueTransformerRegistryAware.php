<?php declare(strict_types=1);

namespace Shopware\Framework\Api2\FieldAware;

use Shopware\Framework\Api2\ApiValueTransformer\ValueTransformerRegistry;

interface ValueTransformerRegistryAware
{
    public function setValueTransformerRegistry(ValueTransformerRegistry $valueTransformerRegistry): void;
}