<?php

namespace ElasticExportTreepodiaCOM\Generator;

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

class TreepodiaCOM extends XMLPluginGenerator
{
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
     * @var ElasticExportCoreHelper $elasticExportHelper
     */
    private $elasticExportHelper;

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
     * @var array $idlVariations
     */
    private $idlVariations = array();

    /**
     * TreepodiaDE constructor.
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
     * @param array $resultData
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($resultData, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);
        if(is_array($resultData['documents']) && count($resultData['documents']) > 0)
        {
            $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

            //Create a List of all VariationIds
            $variationIdList = array();
            foreach($resultData['documents'] as $variation)
            {
                $variationIdList[] = $variation['id'];
            }

            //Get the missing fields in ES from IDL
            if(is_array($variationIdList) && count($variationIdList) > 0)
            {
                /**
                 * @var \ElasticExportTreepodiaCOM\IDL_ResultList\TreepodiaCOM $idlResultList
                 */
                $idlResultList = pluginApp(\ElasticExportTreepodiaCOM\IDL_ResultList\TreepodiaCOM::class);
                $idlResultList = $idlResultList->getResultList($variationIdList, $settings, $filter);
            }

            //Creates an array with the variationId as key to surpass the sorting problem
            if(isset($idlResultList) && $idlResultList instanceof RecordList)
            {
                $this->createIdlArray($idlResultList);
            }
            
            foreach($resultData['documents'] as $item)
            {
                if(!array_key_exists($item['id'], $this->idlVariations))
                {
                    continue;
                }

                $product = $this->createElement('product');
                $this->root()->appendChild($product);

                // sku
                $product->appendChild($this->createElement('sku', $item['data']['item']['id']));

                // price
                $product->appendChild($this->createElement('price', number_format((float)$this->idlVariations[$item['id']]['variationRetailPrice.price'], 2)));

                // name
                $product->appendChild($this->createElement('name', $this->elasticExportHelper->getName($item, $settings)));

                // commodity
                $category = $this->getTopLevelCategory($item, $settings);

                if($category instanceof Category)
                {
                    foreach($category->details as $detail)
                    {
                        if($detail->lang == $settings->get('lang'))
                        {
                            $product->appendChild($this->createElement('commodity', $detail->name));
                        }
                    }
                }


                // description
                $product->appendChild($description = $this->createElement('description'));
                $description->appendChild($this->createCDATASection($this->elasticExportHelper->getDescription($item, $settings)));

                // brand-name, brand-logo
                if((int) $item['data']['item']['manufacturer']['id'] > 0)
                {
                    $manufacturer = $this->getProducer((int)$item['data']['item']['manufacturer']['id']);

                    if($manufacturer instanceof Manufacturer)
                    {
                        if(strlen($manufacturer->externalName) > 0)
                        {
                            $product->appendChild($brandName = $this->createElement('brand-name'));
                            $brandName->appendChild($this->createCDATASection($manufacturer->externalName));
                        }
                        elseif(strlen($manufacturer->name) > 0)
                        {
                            $product->appendChild($brandName = $this->createElement('brand-name'));
                            $brandName->appendChild($this->createCDATASection($manufacturer->name));
                        }

                        if(strlen($manufacturer->logo) > 0)
                        {
                            $product->appendChild($this->createElement('brand_logo', $manufacturer->logo));
                        }
                    }
                }

                // page-url
                $product->appendChild($pageUrl = $this->createElement('page-url'));
                $pageUrl->appendChild($this->createCDATASection($this->elasticExportHelper->getUrl($item, $settings, false)));

                // image-url
                foreach($this->elasticExportHelper->getImageList($item, $settings) as $image)
                {
                    $product->appendChild($this->createElement('image-url', $image));
                }

                // catch-phrase
                foreach($this->getCatchPhraseList($item) as $catchPhrase)
                {
                    $product->appendChild($this->createElement('catch-phrase', htmlspecialchars($catchPhrase)));
                }

                $deliveryCost = $this->elasticExportHelper->getShippingCost($item['data']['item']['id'], $settings);
                if(is_null($deliveryCost))
                {
                    $deliveryCost = 0.00;
                }


                // free-shipping
                if($deliveryCost <= 0.00)
                {
                    $product->appendChild($this->createElement('free-shipping', 1));
                }

                // youtubetag, Video-Sitemaptag
                foreach($this->getKeywords($item, $settings) as $keyword)
                {
                    $product->appendChild($this->createElement('youtubetag', htmlspecialchars(trim($keyword))));
                    $product->appendChild($this->createElement('Video-Sitemaptag', htmlspecialchars(trim($keyword))));
                }
            }

            $this->build();
        }
    }

    /**
     * Get the top level category.
     * @param array $item
     * @param KeyValue $settings
     * @return Category
     */
    public function getTopLevelCategory($item, KeyValue $settings):Category
    {
        $lang = $settings->get('lang') ? $settings->get('lang') : 'de';

        if(is_null($item['data']['defaultCategories'][0]['id']))
        {
            return null;
        }

        $categoryBranch = $this->categoryBranchRepository->find($item['data']['defaultCategories'][0]['id']);

        if(!is_null($categoryBranch) && $categoryBranch instanceof CategoryBranch)
        {
            $list = [
                $categoryBranch->category6Id,
                $categoryBranch->category5Id,
                $categoryBranch->category4Id,
                $categoryBranch->category3Id,
                $categoryBranch->category2Id,
                $categoryBranch->category1Id
            ];

            $categoryList = [];

            foreach($list AS $category)
            {
                if($category > 0)
                {
                    $categoryList[] = $category;
                }
            }

            $categoryId = $categoryList[0];

            return $this->categoryRepository->get((int) $categoryId, $lang);
        }

        return null;
    }

    /**
     * Get producer.
     * @param int $manufacturerId
     * @return Manufacturer
     */
    public function getProducer(int $manufacturerId):Manufacturer
    {
        return $this->manufacturerRepository->findById($manufacturerId);
    }

    /**
     * Get catch phrase list.
     * @param array $item
     * @return array<string>
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
     * @param array $item
     * @param KeyValue $settings
     * @return array<string>
     */
    public function getKeywords(array $item, KeyValue $settings):array
    {
        $list = explode(',', $item['data']['texts'][0]['keywords']);

        $category = $this->getTopLevelCategory($item, $settings);
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

    /**
     * @param RecordList $idlResultList
     */
    private function createIdlArray($idlResultList)
    {
        if($idlResultList instanceof RecordList)
        {
            foreach($idlResultList as $idlVariation)
            {
                if($idlVariation instanceof Record)
                {
                    $this->idlVariations[$idlVariation->variationBase->id] = [
                        'itemBase.id' => $idlVariation->itemBase->id,
                        'variationBase.id' => $idlVariation->variationBase->id,
                        'variationStock.stockNet' => $idlVariation->variationStock->stockNet,
                        'variationRetailPrice.price' => $idlVariation->variationRetailPrice->price,
                    ];
                }
            }
        }
    }
}
