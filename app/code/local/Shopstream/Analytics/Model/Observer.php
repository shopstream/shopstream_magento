<?php

class Shopstream_Analytics_Model_Observer
{
    /**
     * Create Shopstream Analytics block for success page view
     *
     * @deprecated after 1.3.2.3 Use setShopstreamAnalyticsOnOrderSuccessPageView() method instead
     * @param Varien_Event_Observer $observer
     */
    public function order_success_page_view($observer)
    {
        $this->setShopstreamAnalyticsOnOrderSuccessPageView($observer);
    }

    /**
     * Add order information into GA block to render on checkout success pages
     *
     * @param Varien_Event_Observer $observer
     */
    public function setShopstreamAnalyticsOnOrderSuccessPageView(Varien_Event_Observer $observer)
    {
        $orderIds = $observer->getEvent()->getOrderIds();
        if (empty($orderIds) || !is_array($orderIds)) {
            return;
        }
        $block = Mage::app()->getFrontController()->getAction()->getLayout()->getBlock('success_page_js');
        if ($block) {
            $block->setOrderIds($orderIds);
        }
    }
}
