<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Source Model class
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
namespace Stepzerosolutions\Dps\Model\Config\Source;

/**
 * PxPay Systemlogos Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Systemlogos
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options array
     *
     * @return $this
     */
    public function toOptionArray()
    {
        $logos = array(
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_VISA => 'Visa',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_VISAVERIFIED 
            => 'Verified by Visa',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_MASTERCARD => 'MasterCard',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_MASTERCARDSECURE 
            => 'MasterCard SecureCode',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_AMEX 
            => 'American Express',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_JCB => 'JCB',
            \Stepzerosolutions\Dps\Model\Common::LOGOFILE_DINERS => 'Diners'
        );
        $options = [];
        foreach ($logos as $key => $value ) {
            $options[] = ['value' => $key, 'label' => $value];
        }
        return $options;
    }
}