<?php

/**
 * Created by IntelliJ IDEA.
 * User: stefano
 * Date: 03/10/2016
 * Time: 11:19
 */
class Hevelop_FacebookOgMeta_Block_OgMeta extends
    Mage_Core_Block_Template
{
    public function getMetaData()
    {
        //Product page
        if ($this->getCurrentProd() && $this->getCurrentProd()->getId()) :
            $type = "product";
            $title = $this->getCurrentProd()->getName();
            $url = Mage::registry('product')->getProductUrl();
            $desc = strip_tags($this->getCurrentProd()->getDescription());
            $image = $this->helper('catalog/image')->init($this->getCurrentProd(), 'small_image');
        elseif ($this->getCurrentCat() && $this->getCurrentCat()->getId()):
            //Category Page
            $type = "product.group";
            $title = $this->getCurrentCat()->getName();
            $url = $this->helper('core/url')->getCurrentUrl();
            $desc = strip_tags($this->getCurrentCat()->getShortDescription());
            $image = $this->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));
        elseif ($this->getCms()->getId() && $this->getCms()->getIdentifier() == $this->getHomePageConfig()) :
            //Home page
            $type = "website";
            $title = $this->getCms()->getTitle();
            $url = $this->helper('core/url')->getCurrentUrl();
            $desc = strip_tags($this->getCms()->getContentHeading());
            $image = $this->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));
        elseif ($this->getCms()->getId()) :
            //CMS PAGE
            $type = "article";
            $title = $this->getCms()->getTitle();
            $url = $this->helper('core/url')->getCurrentUrl();
            $desc = strip_tags(strip_tags($this->getCms()->getContentHeading()));
            $image = $this->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));
        else:
            $type = "article";
            $title = Mage::getStoreConfig('design/head/default_title');
            $url = $this->helper('core/url')->getCurrentUrl();
            $desc = strip_tags(Mage::getStoreConfig('design/head/default_description'));
            $image = $this->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));
        endif;
        $sitename = Mage::app()->getStore()->getName();
        $html = '';
        $html .= "<meta property=\"og:type\" content=\"$type\" />";
        $html .= "<meta property=\"og:title\" content=\"$title\"/>";
        $html .= "<meta property=\"og:url\" content=\"$url\" />";
        $html .= "<meta property=\"og:sitename\" content=\"$sitename\" />";
        $html .= "<meta property=\"og:description\" content=\"$desc\" />";
        $html .= "<meta property=\"og:image\" content=\"$image\" />";
        return $html;

    }

    protected function getCurrentProd()
    {
        $product = Mage::registry('current_product');
        return $product;
    }

    protected function getCurrentCat()
    {
        $category = Mage::registry('current_category');
        return $category;
    }

    protected function getCms()
    {
        $page = Mage::getSingleton('cms/page');
        return $page;
    }

    protected function getHomePageConfig()
    {
        $HpConfig = Mage::getStoreConfig('web/default/cms_home_page');
        return $HpConfig;
    }

}