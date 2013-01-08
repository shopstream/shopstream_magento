<?php

class Shopstream_Analytics_Block_Success_Page_Js extends Mage_Core_Block_Template
{
    /**
     * Set default template and help including Shopstream JS for all success pages of magento.
     *
     */
    protected function _construct()
    {
        $this->setTemplate('analytics/success_page_js.phtml');
    }

	/**
     * Check if any Order information
     *
     * @return string
     */
    protected function _isOrderTrackSa()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return 0;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds))
        ;
        $result = 0;
        foreach ($collection as $order) {
            $result = 1;
        }
        return $result;
    }
	
	/**
     * Render information about specified orders and their items
     *
     * @return string
     */
    protected function _getOrdersTrackingCodeSA()
    {
        $orderIds = $this->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds))
        ;
        $result = array();
        foreach ($collection as $order) {
            if ($order->getIsVirtual()) {
                $address = $order->getBillingAddress();
            } else {
                $address = $order->getShippingAddress();
            }

            $result[] = sprintf("_shopstream.push(['addOrder', '%s', '%s', '%s', '%s', '%s']);",
                $order->getIncrementId(),
                $order->getBaseGrandTotal(),
                $this->jsQuoteEscape(Mage::helper('core')->escapeHtml($address->getEmail())),
                $this->jsQuoteEscape(Mage::helper('core')->escapeHtml($address->getFirstname())),
                $this->jsQuoteEscape(Mage::helper('core')->escapeHtml($address->getLastname()))
            );
            foreach ($order->getAllVisibleItems() as $item) {
                $result[] = sprintf("_shopstream.push(['addItem', '%s', '%s', '%s', '%s']);",
                    $this->jsQuoteEscape($item->getSku()),
					$this->jsQuoteEscape($item->getName()),
                    $item->getBasePrice(),
					$item->getQtyOrdered()
                );
            }
            $result[] = "_shopstream.push(['trackOrder']);";
        }
        return implode("\n", $result);
    }

    /**
     * Render Shopstream_Analytics tracking scripts
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!Mage::helper('analytics')->isShopstreamAnalyticsAvailable()) {
            return '';
        }

        return parent::_toHtml();
    }
}