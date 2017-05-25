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
 * PxPay Urls Class.
 *
 * @category Model
 *
 * @package  Socialwall
 * @author   Don Nuwinda <nuwinda@gmail.com>
 * @license  GPL http://stepzero.solutions
 * @link     http://stepzero.solutions
 */
class Dpsurls extends \Stepzerosolutions\Dps\Model\Common
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options array
     *
     * @return $this
     */
    public function toOptionArray()
    {
        return $this->getPxpayUrls();
    }
}
