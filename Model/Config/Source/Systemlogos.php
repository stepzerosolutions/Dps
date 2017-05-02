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
  
class Systemlogos
implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
		$logos = array(
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_VISA => 'Visa',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_VISAVERIFIED => 'Verified by Visa',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_MASTERCARD => 'MasterCard',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_MASTERCARDSECURE => 'MasterCard SecureCode',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_AMEX => 'American Express',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_JCB => 'JCB',
			\Stepzerosolutions\Dps\Model\Common::LOGOFILE_DINERS => 'Diners'
		);
		$options = [];
		foreach($logos as $key => $value ){
			$options[] = ['value' => $key, 'label' => $value];
		}	
		return $options;		
    }
}
