<?php
use \Bitrix\Main\Localization\Loc as Loc;
use \Bitrix\Main\SystemException as SystemException;
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

CBitrixComponent::includeComponentClass("bitrix:catalog.viewed.products");

class CSaleBestsellersComponent extends CCatalogViewedProductsComponent
{
	/**
	 * @param $params
	 * @override
	 * @return array
	 */
	public function onPrepareComponentParams($params)
	{
		$params = parent::onPrepareComponentParams($params);

		if(!isset($params["CACHE_TIME"]))
			$params["CACHE_TIME"] = 86400;

		$params["DETAIL_URL"] = trim($params["DETAIL_URL"]);

		if(isset($params["BY"]) && is_array($params["BY"]))
		{
			if(count($params["BY"]))
			{
				$params["BY"] = array_values($params["BY"]);
				$params["BY"] = $params["BY"][0];
			}
			else
				$params["BY"] = "AMOUNT";
		}

		if(!isset($params["BY"]) || !strlen(trim($params["BY"])))
			$params["BY"] = "AMOUNT";


		if(isset($params["PERIOD"]))
		{
			if(is_array($params["PERIOD"]))
			{
				if(count($params["PERIOD"]))
				{
					$params["PERIOD"] = array_values($params["PERIOD"]);
					$params["PERIOD"] = $params["PERIOD"][0];
				}
				else
					$params["PERIOD"] = 0;
			}
			else
			{
				$params["PERIOD"] = (int)$params["PERIOD"];
				if($params["PERIOD"] < 0 || $params["PERIOD"] > 180)
					$params["PERIOD"] = 0;
			}
		}
		else
		{
			$params["PERIOD"] = 0;
		}

		$statuses = array("CANCELED", "ALLOW_DELIVERY", "PAYED", "DEDUCTED");
		$saleStatusIterator = CSaleStatus::GetList(Array("SORT" => "ASC"), Array("LID" => LANGUAGE_ID), false, false, Array("ID", "NAME", "SORT"));
		while ($row = $saleStatusIterator->GetNext())
		{
			$statuses[] = $row['ID'];
		}

		if(!isset($params['FILTER']) || !is_array($params['FILTER']))
			$params['FILTER'] = array();

		foreach($params['FILTER'] as $key => $status)
		{
			if(!in_array($status, $statuses))
				unset($params['FILTER'][$key]);
		}
		return $params;
	}

	/**
	 * Simple method used to member request param.
	 * @return void
	 */
	protected function doByRequest()
	{
		if(!isset($_REQUEST['by']))
			return;
		$this->by = strtoupper($_REQUEST['by']) == "QUANTITY" ? "QUANTITY" : "AMOUNT";
	}

	/**
	 * Simple method used to member request param.
	 * @return void
	 */
	protected function doDaysRequest()
	{
		if(!isset($_REQUEST['days']))
			return;
		$this->days = (int)$_REQUEST['days'] > 0 ? (int)$_REQUEST['days'] : 30;
	}

	/**
	 * @override
	 * @return void
	 */
	protected function doActionsList()
	{
		parent::doActionsList();
		$this->doByRequest();
		$this->doDaysRequest();
	}

	/**
	 * @override
	 * @return bool
	 */
	protected function extractDataFromCache()
	{
		if($this->arParams['CACHE_TYPE'] == 'N')
			return false;

		global $USER;
		return !($this->StartResultCache(false, $USER->GetGroups() . "-" . $this->by . "-" . $this->days ));
	}

	protected function putDataToCache()
	{
		$this->endResultCache();
	}

	protected function abortDataCache()
	{
		$this->AbortResultCache();
	}

	/**
	 * @override
	 * @return void
	 */
	protected function formatResult()
	{
		parent::formatResult();
		$this->arResult['PERIOD'] 	= $this->arParams['PERIOD'];
		$this->arResult['BY'] 		= $this->arParams['BY'];
		$this->arResult['DAYS']		= $this->days;
		$this->arResult['BY_VAL']   = $this->by;
	}

	/**
	 * Returns basket properties filter for CSaleProduct::GetBestSellerList method.
	 * @return mixed[]
	 */
	protected function getBasketPropsFilter()
	{
		$propsFilter = array();
		if(strlen($this->arParams["FILTER_NAME"]) <= 0 ||!preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $this->arParams["FILTER_NAME"]))
		{
			$propsFilter = array();
		}
		else
		{
			$propsFilter = $GLOBALS[$this->arParams["FILTER_NAME"]];
			if(!is_array($propsFilter))
				$propsFilter = array();
		}
		return $propsFilter;
	}

	/**
	 * Returns orders filter for CSaleProduct::GetBestSellerList method.
	 * @return mixed[]
	 */
	protected function getOrdersFilter()
	{
		if(count($this->arParams['FILTER']) && $this->arParams['PERIOD'])
		{
			$filter = array("=LID" => SITE_ID);
			$subFilter = array("LOGIC" => "OR");

			$statuses = array("CANCELED", "ALLOW_DELIVERY", "PAYED", "DEDUCTED");
			$date = ConvertTimeStamp(AddToTimeStamp(Array("DD" => "-" . $this->arParams['PERIOD'])));
			foreach($this->arParams['FILTER'] as $field)
			{
				if(in_array($field, $statuses))
				{
					$subFilter[] = array(
						">=DATE_{$field}" => $date,
						"={$field}" => "Y"
					);
				}
				else
				{
					$subFilter[] = array(
						"=STATUS_ID" => $field,
						">=DATE_UPDATE" => $date,
					);
				}
			}
			$filter[] = $subFilter;
			return $filter;
		}

		return array();
	}

	/**
	 * @override
	 * @return integer[]
	 */
	protected function getProductIds()
	{
		$ordersfilter = $this->getOrdersFilter();
		if(!empty($ordersfilter))
		{
			$productIds = array();
			$productIterator = CSaleProduct::GetBestSellerList(
				$this->arParams["BY"],
				array(),
				$ordersfilter,
				$this->arParams["PAGE_ELEMENT_COUNT"]
			);
			while($product = $productIterator->fetch())
			{
				$productIds[] = $product['PRODUCT_ID'];
			}

			return $productIds;
		}

		return array();
	}


	/**
	 * @override
	 * @throws Exception
	 */
	protected function checkModules()
	{
		parent::checkModules();
		if(!$this->isSale)
			throw new SystemException(Loc::getMessage("CVP_SALE_MODULE_NOT_INSTALLED"));
	}

}
?>