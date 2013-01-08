<?php

class Shopstream_Analytics_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_ACTIVE = 'analytics/shopstream_group/shopstream_analytics_enabled';
	const XML_PATH_ACCOUNT = 'analytics/shopstream_group/shopstream_api';

	public function isShopstreamAnalyticsAvailable($store = null)
    {
        $accountId = Mage::getStoreConfig(self::XML_PATH_ACCOUNT, $store);
        return $accountId && Mage::getStoreConfigFlag(self::XML_PATH_ACTIVE, $store);
    }
}