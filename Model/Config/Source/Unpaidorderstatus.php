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
 * PxPay Unpaidorderstatus Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Unpaidorderstatus
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options array
     *
     * @return $this
     */
    public function toOptionArray()
    {
        return [
            \Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PENDING 
            => 'Pending',
            \Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PENDING_DPS 
            => 'Pending Payment (DPS)',
            \Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PROCESSING_DPS_AUTH 
            => 'Processing (DPS - Amount authorised)',
            \Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PROCESSING_DPS_PAID 
            => 'Processing (DPS - Amount paid)'
        ];
    }
}