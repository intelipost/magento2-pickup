<?php
/*
 * @package     Intelipost_Pickup
 * @copyright   Copyright (c) 2016 Gamuza Technologies (http://www.gamuza.com.br/)
 * @author      Eneias Ramos de Melo <eneias@gamuza.com.br>
 */

namespace Intelipost\Pickup\Model\Items;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteria;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\App\RequestInterface;

use Intelipost\Pickup\Model\Resource\Items\Collection as ItemsCollection;
use Intelipost\Pickup\Model\Resource\Items\CollectionFactory as ItemsCollectionFactory;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{

protected $collection;

protected $loadedData;

public function __construct(
    $name,
    $primaryFieldName,
    $requestFieldName,
    Reporting $reporting,
    SearchCriteriaBuilder $searchCriteriaBuilder,
    RequestInterface $request,
    FilterBuilder $filterBuilder,
    ItemsCollectionFactory $itemsCollectionFactory,
    array $meta = [],
    array $data = []
) {
    $this->collection = $itemsCollectionFactory->create();
    // $this->collection->addAttributeToSelect('*');

    $this->request = $request;
    $this->filterBuilder = $filterBuilder;
    $this->name = $name;
    $this->primaryFieldName = $primaryFieldName;
    $this->requestFieldName = $requestFieldName;
    $this->reporting = $reporting;
    $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    $this->meta = $meta;
    $this->data = $data;
    $this->prepareUpdateUrl();
}

public function getData()
{
    if (isset($this->loadedData))
    {
        return $this->loadedData;
    }

    $items = $this->collection->getItems();
    foreach ($items as $_item)
    {
        $result['item'] = $_item->getData();

        $this->loadedData[$_item->getId()] = $result;
    }

    return $this->loadedData;
}

}

