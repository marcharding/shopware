<?php declare(strict_types=1);

namespace Shopware\Product\Writer\ResourceDefinition;

use Shopware\Framework\Api\ApiFieldFactory;
use Shopware\Framework\Api\FieldBuilder;
use Shopware\Framework\Api\ApiFieldTemplate\BooleanType;
use Shopware\Framework\Api\ApiFieldTemplate\DateType;
use Shopware\Framework\Api\ApiFieldTemplate\FKType;
use Shopware\Framework\Api\ApiFieldTemplate\LongTextType;
use Shopware\Framework\Api\ApiFieldTemplate\LongTextWithHtmlType;
use Shopware\Framework\Api\ApiFieldTemplate\NowDefaultValueTemplate;
use Shopware\Framework\Api\ApiFieldTemplate\PKType;
use Shopware\Framework\Api\ApiFieldTemplate\TextType;
use Shopware\Framework\Api\ApiFieldTemplate\IntType;
use Shopware\Framework\Api\ApiFieldTemplate\FloatType;
use Shopware\Framework\Api\UuidGenerator\RamseyGenerator;

class BaseProductRelationshipResourceFactory extends ApiFieldFactory
{
    public function getUuidGeneratorClass(): string
    {
        return RamseyGenerator::class;    
    }

    public function getTableName(): string
    {
        return 'product_relationship';    
    }
    
    public function getResourceName(): string
    {
        return 'ProductRelationship';    
    }

    protected function build(FieldBuilder $builder): FieldBuilder
    {
        return $builder
            ->start()
            ->add('productId')
            ->setWritable('product_id')
            ->fromTemplate(IntType::class)
            ->setRequired()
        ->add('productUuid')
            ->setWritable('product_uuid')
            ->fromTemplate(TextType::class)
            ->setRequired()
            ->setForeignKey('Product.uuid')
        ->add('relatedProduct')
            ->setWritable('related_product')
            ->fromTemplate(TextType::class)
            ->setRequired()
        ->add('relatedProductUuid')
            ->setWritable('related_product_uuid')
            ->fromTemplate(TextType::class)
            ->setRequired()
            ->setForeignKey('Product.uuid')
        ->add('uuid')
            ->setWritable('uuid')
            ->fromTemplate(TextType::class)
            ->setPrimary()
            ->setRequired()
        ->add('product')
            ->setVirtual('productUuid', 'Product')
        ->add('relatedProduct')
            ->setVirtual('relatedProductUuid', 'Product');
    }
}
