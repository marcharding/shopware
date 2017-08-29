<?php declare(strict_types=1);

namespace Shopware\Search\Gateway\Resource;

use Shopware\Framework\Api2\ApiFlag\Required;
use Shopware\Framework\Api2\Field\FkField;
use Shopware\Framework\Api2\Field\IntField;
use Shopware\Framework\Api2\Field\ReferenceField;
use Shopware\Framework\Api2\Field\StringField;
use Shopware\Framework\Api2\Field\BoolField;
use Shopware\Framework\Api2\Field\DateField;
use Shopware\Framework\Api2\Field\SubresourceField;
use Shopware\Framework\Api2\Field\LongTextField;
use Shopware\Framework\Api2\Field\LongTextWithHtmlField;
use Shopware\Framework\Api2\Field\FloatField;
use Shopware\Framework\Api2\Field\TranslatedField;
use Shopware\Framework\Api2\Field\UuidField;
use Shopware\Framework\Api2\Resource\ApiResource;

class SearchCustomFacetResource extends ApiResource
{
    public function __construct()
    {
        parent::__construct('s_search_custom_facet');
        
        $this->fields['active'] = (new BoolField('active'))->setFlags(new Required());
        $this->fields['uniqueKey'] = new StringField('unique_key');
        $this->fields['displayInCategories'] = (new IntField('display_in_categories'))->setFlags(new Required());
        $this->fields['deletable'] = (new IntField('deletable'))->setFlags(new Required());
        $this->fields['position'] = (new IntField('position'))->setFlags(new Required());
        $this->fields['name'] = (new StringField('name'))->setFlags(new Required());
        $this->fields['facet'] = (new LongTextField('facet'))->setFlags(new Required());
    }
    
    public function getWriteOrder(): array
    {
        return [
            \Shopware\Search\Gateway\Resource\SearchCustomFacetResource::class
        ];
    }
}
