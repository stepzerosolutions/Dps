<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Block\Payment;

/**
 * DPS PxPay Magento 2 Module
 *
 */

class Info extends Magento\Payment\Block\Info
{

    /**
     * @var string
     */
    protected $_template = 'Stepzerosolutions_Dps::info/pdf/default.phtml';

    /**
     * Retrieve info model
     *
     * @return \Magento\Payment\Model\InfoInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getInfo()
    {
        $info = $this->getData('info');
        if (!$info instanceof \Magento\Payment\Model\InfoInterface) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('We cannot retrieve the payment info model object.')
            );
        }
        return $info;
    }
	
    /**
     * Render as PDF
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Stepzerosolutions_Dps::info/pdf/default.phtml');
        return $this->toHtml();
    }
}
