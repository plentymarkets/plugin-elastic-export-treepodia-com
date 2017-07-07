<?php

namespace ElasticExportTreepodiaCOM\Generator;

use ElasticExport\Helper\ElasticExportPriceHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use Plenty\Modules\Category\Models\CategoryBranch;
use Plenty\Modules\DataExchange\Contracts\XMLPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\Category\Contracts\CategoryBranchRepositoryContract;
use Plenty\Modules\Category\Contracts\CategoryRepositoryContract;
use Plenty\Modules\Item\Manufacturer\Contracts\ManufacturerRepositoryContract;
use Plenty\Modules\Item\Manufacturer\Models\Manufacturer;
use Plenty\Modules\Category\Models\Category;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;

/**
 * Class TreepodiaCOM
 *
 * @package ElasticExportTreepodiaCOM\Generator
 */
class TreepodiaCOM extends XMLPluginGenerator
{
	use Loggable;

    /**
     * @var string
     */
    protected $version = '1.0';

    /**
     * @var string
     */
    protected $encoding = 'UTF-8';

    /**
     * @var bool
     */
    protected $formatOutput = true;

    /**
     * @var bool
     */
    protected $preserveWhiteSpace = true;

	/**
	 * @var array $manufacturerCache
	 */
	private $manufacturerCache = [];

    /**
     * @var ElasticExportCoreHelper $elasticExportHelper
     */
    private $elasticExportHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
    private $elasticExportStockHelper;

	/**
	 * @var ElasticExportPriceHelper $elasticExportPriceHelper
	 */
    private $elasticExportPriceHelper;

    /*
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * CategoryBranchRepositoryContract $categoryBranchRepository
     */
    private $categoryBranchRepository;

    /**
     * CategoryRepositoryContract $categoryRepository
     */
    private $categoryRepository;

    /**
     * ManufacturerRepositoryContract $manufacturerRepository
     */
    private $manufacturerRepository;

    /**
     * TreepodiaDE constructor.
	 *
     * @param ArrayHelper $arrayHelper
     * @param CategoryBranchRepositoryContract $categoryBranchRepository
     * @param CategoryRepositoryContract $categoryRepository
     * @param ManufacturerRepositoryContract $manufacturerRepository
     */
    public function __construct(
        ArrayHelper $arrayHelper,
        CategoryBranchRepositoryContract $categoryBranchRepository,
        CategoryRepositoryContract $categoryRepository,
        ManufacturerRepositoryContract $manufacturerRepository
    )
    {
        $this->arrayHelper = $arrayHelper;
        $this->categoryBranchRepository = $categoryBranchRepository;
        $this->categoryRepository = $categoryRepository;
        $this->manufacturerRepository = $manufacturerRepository;

        $this->init('products');
    }

    /**
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);
        $this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);
        $this->elasticExportPriceHelper = pluginApp(ElasticExportPriceHelper::class);
        
		$settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');
		
		$limitReached = false;
		$lines = 0;
		$startTime = microtime(true);

        if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
		{
			do
			{
				if($limitReached === true)
				{
					break;
				}

				$this->getLogger(__METHOD__)->debug('ElasticExportTreepodiaCOM::log.writtenlines', ['lines written' => $lines]);

				$esStartTime = microtime(true);

				$resultList = $elasticSearch->execute();

				$this->getLogger(__METHOD__)->debug('ElasticExportTreepodiaCOM::log.esDuration', [
					'Elastic Search duration' => microtime(true) - $esStartTime,
				]);

				if(count($resultList['error']) > 0)
				{
					$this->getLogger(__METHOD__)->error('ElasticExportTreepodiaCOM::log.occurredElasticSearchErrors', [
						'error message' => $resultList['error'],
					]);
				}

				$buildRowStartTime = microtime(true);

				if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
				{
					foreach($resultList['documents'] as $item)
					{
						if($this->elasticExportStockHelper->isFilteredByStock($item, $filter))
						{
							continue;
						}
						
						try
						{
							$this->buildProduct($item, $settings);
							$lines++;
						}
						catch(\Throwable $exception)
						{
							$this->getLogger(__METHOD__)->error('ElasticExportTreepodiaCOM::log.buildRowError', [
								'error' => $exception->getMessage(),
								'line' => $exception->getLine(),
								'variation ID' => $item['id']
							]);
						}

						$this->getLogger(__METHOD__)->debug('ElasticExportTreepodiaCOM::log.buildRowDuration', [
							'Build Row duration' => microtime(true) - $buildRowStartTime,
						]);

						if($lines == $filter['limit'])
						{
							$limitReached = true;
							break;
						}
					}
				}
			}
			while($elasticSearch->hasNext());

			// finish file
			$this->build();
		}

		$this->getLogger(__METHOD__)->debug('ElasticExportTreepodiaCOM::log.fileGenerationDuration', [
			'Whole file generation duration' => microtime(true) - $startTime,
		]);
    }

	/**
	 * @param array $item
	 * @param KeyValue $settings
	 */
    private function buildProduct($item, $settings)
	{
		$product = $this->createElement('product');
		$this->root()->appendChild($product);

		// sku
		$product->appendChild($this->createElement('sku', $item['id']));

		// price
		$priceList = $this->elasticExportPriceHelper->getPriceList($item, $settings);

		if(strlen((string)$priceList['price']) || strlen((string)$priceList['specialPrice']))
		{
			$priceTag = $this->createElement('price');
			$product->appendChild($priceTag);

			if(strlen((string)$priceList['price']))
			{
				$priceTag->appendChild($this->createElement('value', (string)$priceList['price']));
			}

			if(strlen((string)$priceList['specialPrice']))
			{
				$priceTag->appendChild($this->createElement('sale', (string)$priceList['specialPrice']));
			}
		}

		// name
		$product->appendChild($this->createElement('name', $this->elasticExportHelper->getMutatedName($item, $settings)));

		// category, top category or full path allowed
		$category = $this->getCategoryPath($item, $settings);

		if($category instanceof Category)
		{
			foreach($category->details as $detail)
			{
				if($detail->lang == $settings->get('lang'))
				{
					if(strlen(trim($detail->name)))
					{
						$product->appendChild($this->createElement('category', (string)$detail->name));
					}
				}
			}
		}

		// description
		$product->appendChild($description = $this->createElement('description'));
		$description->appendChild($this->createCDATASection($this->elasticExportHelper->getMutatedDescription($item, $settings)));

		// brand name and logo
		if((int) $item['data']['item']['manufacturer']['id'] > 0)
		{
			$manufacturer = $this->getManufacturer((int)$item['data']['item']['manufacturer']['id']);

			if($manufacturer instanceof Manufacturer)
			{
				$product->appendChild($brandTag = $this->createElement('brand'));

				if(strlen($manufacturer->externalName) > 0)
				{
					$brandTag->appendChild($name = $this->createElement('name'));
					$name->appendChild($this->createCDATASection($manufacturer->externalName));
				}
				elseif(strlen($manufacturer->name) > 0)
				{
					$brandTag->appendChild($name = $this->createElement('name'));
					$name->appendChild($this->createCDATASection($manufacturer->name));
				}

				if(strlen($manufacturer->logo) > 0)
				{
					$brandTag->appendChild($name = $this->createElement('logo'));
					$name->appendChild($this->createCDATASection($manufacturer->logo));
				}
			}
		}

		// page-url
		$product->appendChild($pageUrl = $this->createElement('page-url'));
		$pageUrl->appendChild($this->createCDATASection($this->elasticExportHelper->getMutatedUrl($item, $settings, false)));

		// image-url
		$product->appendChild($imageTag = $this->createElement('image'));

		foreach($this->elasticExportHelper->getImageList($item, $settings) as $image)
		{
			$imageTag->appendChild($this->createElement('url', $image));
		}

		// catch-phrase
		foreach($this->getCatchPhraseList($item) as $catchPhrase)
		{
			$product->appendChild($this->createElement('catch-phrase', htmlspecialchars($catchPhrase)));
		}

		// shipping
		$shippingCost = $this->elasticExportHelper->getShippingCost($item['data']['item']['id'], $settings);

		if(!is_null($shippingCost))
		{
			$product->appendChild($this->createElement('shipping', $shippingCost));
		}

		// tags
		$keyList = [];

		foreach($this->getKeywords($item, $settings) as $keyword)
		{
			if(strlen($keyword))
			{
				$keyList[] = $keyword;
			}
		}

		$product->appendChild($this->createElement('tags', implode(', ', $keyList)));
	}

    /**
     * Get the whole category path.
	 *
     * @param array $item
     * @param KeyValue $settings
     * @return string
     */
    public function getCategoryPath($item, KeyValue $settings)
    {
        $lang = $settings->get('lang') ? $settings->get('lang') : 'de';

        if(is_null($item['data']['defaultCategories'][0]['id']))
        {
            return '';
        }

        $categoryBranch = $this->categoryBranchRepository->find($item['data']['defaultCategories'][0]['id']);

        if(!is_null($categoryBranch) && $categoryBranch instanceof CategoryBranch)
        {
            $list = [
                $categoryBranch->category1Id,
				$categoryBranch->category2Id,
				$categoryBranch->category3Id,
				$categoryBranch->category4Id,
				$categoryBranch->category5Id,
				$categoryBranch->category6Id,
            ];

            $categoryList = [];

            foreach($list AS $categoryId)
            {
            	if(!is_null($categoryId))
				{
					$category = $this->categoryRepository->get((int) $categoryId, $lang);

					if($category instanceof Category)
					{
						foreach($category->details as $detail)
						{
							$categoryList[] = $detail->name;
						}
					}
				}
            }

            return implode(' > ', $categoryList);
        }

        return '';
    }

    /**
     * Returns the manufacturer by ID.
	 *
     * @param int $manufacturerId
     * @return Manufacturer
     */
    public function getManufacturer(int $manufacturerId):Manufacturer
    {
    	if(!in_array($manufacturerId, $this->manufacturerCache))
		{
			/**
			 * @var Manufacturer $manufacturer
			 */
			$manufacturer = $this->manufacturerRepository->findById($manufacturerId);

			if($manufacturer instanceof Manufacturer)
			{
				$this->manufacturerCache[$manufacturerId] = $manufacturer;
			}
		}

		return $this->manufacturerCache[$manufacturerId];
    }

    /**
     * Get catch phrase list.
	 *
     * @param array $item
     * @return array
     */
    private function getCatchPhraseList($item):array
    {
        $list = [
            $item['data']['item']['free1'],
            $item['data']['item']['free2'],
            $item['data']['item']['free3'],
            $item['data']['item']['free4'],
        ];

        $filteredList = [];

        foreach($list AS $value)
        {
            if(strlen($value) > 0)
            {
                $filteredList[] = $value;
            }
        }

        return $filteredList;
    }

    /**
     * Get keywords.
	 *
     * @param array $item
     * @param KeyValue $settings
     * @return array
     */
    public function getKeywords(array $item, KeyValue $settings):array
    {
        $list = explode(',', $item['data']['texts'][0]['keywords']);

        $category = $this->getCategoryPath($item, $settings);

        if($category instanceof Category)
        {
            foreach($category->details as $detail)
            {
                if($detail->lang == $settings->get('lang'))
                {
                    $list = array_merge($list, explode(',', $detail->metaKeywords));
                }
            }
        }

        return $list;
    }
}
