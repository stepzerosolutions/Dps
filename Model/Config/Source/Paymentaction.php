<?php
/**
 * Copyright © 2015 Stepzero.solutions adventure theme. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Stepzerosolutions\Dps\Model\Config\Source;
/**
 * Payment actions source
 *
 */
  
class Paymentaction
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return [
			\Stepzerosolutions\Dps\Model\Common::ACTION_AUTHORIZE => 'Authorize Only',
			\Stepzerosolutions\Dps\Model\Common::ACTION_COMPLETE => 'Purchase'
		];			
    }
}
