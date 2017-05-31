<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Block class
 *
 * PHP version 7
 *
 * @category Module
 * @package  Dps
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 *
 * @link     http://stepzero.solutions
 */
namespace Stepzerosolutions\Dps\Block\Payment;

/**
 * Info Class.
 *
 * @category Block
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Info extends \Magento\Payment\Block\Info
{

    /**
     * @var string
     */
    public $_template = 'Stepzerosolutions_Dps::info/pdf/default.phtml';

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
     *
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Stepzerosolutions_Dps::info/pdf/default.phtml');
        return $this->toHtml();
    }
}
