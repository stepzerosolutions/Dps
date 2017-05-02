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
  
class Unpaidorderstatus
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		return [
			\Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PENDING => 'Pending',
			\Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PENDING_DPS => 'Pending Payment (DPS)',
			\Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PROCESSING_DPS_AUTH => 'Processing (DPS - Amount authorised)',
			\Stepzerosolutions\Dps\Model\Common::ORDER_STATUS_PROCESSING_DPS_PAID => 'Processing (DPS - Amount paid)'
		];	
				
    }
}
