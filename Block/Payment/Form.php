<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Block\Payment;

/**
 * Block for Bank Transfer payment method form
 */
class Form extends \Magento\Payment\Block\Form
{
    /**
     * Bank transfer template
     *
     * @var string
     */
    protected $_template = 'form/dps.phtml';

}
