<?php

class Shopstream_Analytics_Block_All_Page_Js extends Mage_Core_Block_Template
{
    /**
     * Set default template and help including Shopstream JS for all pages.
     *
     */
    protected function _construct()
    {
        $this->setTemplate('analytics/all_page_js.phtml');
    }
}