<?php

namespace ElasticExportTreepodiaCOM\ResultField;

use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;

/**
 * Class TreepodiaCOM
 *
 * @package ElasticExport\ResultFields
 */
class TreepodiaCOM extends ResultFields
{
    /*
	 * @var ArrayHelper
	 */
    private $arrayHelper;

    /**
     * TreepodiaCOM constructor.
	 *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Generate result fields.
	 *
     * @param  array $formatSettings = []
     * @return array
     */
    public function generateResultFields(array $formatSettings = []):array
    {
        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $reference = $settings->get('referrerId') ? $settings->get('referrerId') : -1;

        $itemDescriptionFields = ['texts.urlPath'];
        $itemDescriptionFields[] = 'texts.keywords';
		$itemDescriptionFields[] = 'texts.lang';

        switch($settings->get('nameId'))
        {
            case 1:
                $itemDescriptionFields[] = 'texts.name1';
                break;
            case 2:
                $itemDescriptionFields[] = 'texts.name2';
                break;
            case 3:
                $itemDescriptionFields[] = 'texts.name3';
                break;
            default:
                $itemDescriptionFields[] = 'texts.name1';
                break;
        }

        if($settings->get('descriptionType') == 'itemShortDescription' || $settings->get('previewTextType') == 'itemShortDescription')
        {
            $itemDescriptionFields[] = 'texts.shortDescription';
        }

        if($settings->get('descriptionType') == 'itemDescription'
            || $settings->get('descriptionType') == 'itemDescriptionAndTechnicalData'
            || $settings->get('previewTextType') == 'itemDescription'
            || $settings->get('previewTextType') == 'itemDescriptionAndTechnicalData')
        {
            $itemDescriptionFields[] = 'texts.description';
        }

        $itemDescriptionFields[] = 'texts.technicalData';

        //Mutator

        /**
         * @var ImageMutator $imageMutator
         */
        $imageMutator = pluginApp(ImageMutator::class);

        if($imageMutator instanceof ImageMutator)
        {
            $imageMutator->addMarket($reference);
        }

        /**
         * @var LanguageMutator $languageMutator
         */
        $languageMutator = pluginApp(LanguageMutator::class, [[$settings->get('lang')]]);

        /**
         * @var DefaultCategoryMutator $defaultCategoryMutator
         */
        $defaultCategoryMutator = pluginApp(DefaultCategoryMutator::class);

        if($defaultCategoryMutator instanceof DefaultCategoryMutator)
        {
            $defaultCategoryMutator->setPlentyId($settings->get('plentyId'));
        }

		/**
		 * @var KeyMutator
		 */
		$keyMutator = pluginApp(KeyMutator::class);

		if($keyMutator instanceof KeyMutator)
		{
			$keyMutator->setKeyList($this->getKeyList());
			$keyMutator->setNestedKeyList($this->getNestedKeyList());
		}

        $fields = [
            [
                //item
                'item.id',
                'item.manufacturer.id',
                'item.free1',
                'item.free2',
                'item.free3',
                'item.free4',

                //variation
                'id',
                'variation.availability.id',
                'variation.stockLimitation',
                'variation.vatId',
                'variation.model',
				'variation.id',

                //images
                'images.item.urlMiddle',
                'images.item.urlPreview',
                'images.item.urlSecondPreview',
                'images.item.url',
                'images.item.path',
                'images.item.position',

                'images.variation.urlMiddle',
                'images.variation.urlPreview',
                'images.variation.urlSecondPreview',
                'images.variation.url',
                'images.variation.path',
                'images.variation.position',

                //categories
                'categories.all',

                //unit
                'unit.content',
                'unit.id',

                //defaultCategories
                'defaultCategories.id',

                //barcodes
                'barcodes.code',
                'barcodes.type',

                //attributes
                'attributes.attributeValueSetId',
                'attributes.attributeId',
                'attributes.valueId',
            ],
            [
                $languageMutator,
                $defaultCategoryMutator,
				$keyMutator
            ],
        ];

        if($reference != -1)
        {
            $fields[1][] = $imageMutator;
        }

        foreach($itemDescriptionFields as $itemDescriptionField)
        {
            $fields[0][] = $itemDescriptionField;
        }

        return $fields;
    }

	/**
	 * @return array
	 */
	private function getKeyList():array
	{
		$keyList = [
			//item
			'item.id',
			'item.manufacturer.id',
			'item.free1',
			'item.free2',
			'item.free3',
			'item.free4',

			//variation
			'variation.availability.id',
			'variation.stockLimitation',
			'variation.vatId',
			'variation.model',
			'variation.isMain',
			'variation.id',

			//unit
			'unit.content',
			'unit.id',
		];

		return $keyList;
	}

	/**
	 * @return array
	 */
	private function getNestedKeyList():array
	{
		$nestedKeyList['keys'] = [
			//images
			'images.all',

			//sku
			'skus',

			//texts
			'texts',

			//defaultCategories
			'defaultCategories',

			//barcodes
			'barcodes',

			//attributes
			'attributes',
		];

		$nestedKeyList['nestedKeys'] = [
			'images.item' => [
				'urlMiddle',
				'urlPreview',
				'urlSecondPreview',
				'url',
				'path',
				'position',
			],

			'images.variation' => [
				'urlMiddle',
				'urlPreview',
				'urlSecondPreview',
				'url',
				'path',
				'position',
			],

			'skus' => [
				'sku'
			],

			'texts'  => [
				'urlPath',
				'name1',
				'name2',
				'name3',
				'shortDescription',
				'description',
				'technicalData',
				'lang'
			],

			'defaultCategories' => [
				'id'
			],

			'barcodes'  => [
				'code',
				'type',
			],

			'attributes'   => [
				'attributeValueSetId',
				'attributeId',
				'valueId'
			],

			'properties'    => [
				'property.id',
			]
		];

		return $nestedKeyList;
	}
}