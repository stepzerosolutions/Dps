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
 * PxPay Emails to send Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Emailstosend
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
            \Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_ORDER 
            => __('Send Order Email Only'),
            \Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_INVOICE 
            => __('Send Invoice Email Only'),
            \Stepzerosolutions\Dps\Model\Common::EMAIL_SEND_BOTH 
            => __('Send Both')
        ];
    }
}