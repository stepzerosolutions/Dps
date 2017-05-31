<?php
/**
 * Dps (http://stepzero.solutions/).
 *
 * Observer class
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
class Form extends \Magento\Payment\Block\Form
{
    /**
     * @var string
     */
    public $_template = 'form/dps.phtml';

}
