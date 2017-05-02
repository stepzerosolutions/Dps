/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
define(
    [
        'Magento_Checkout/js/view/payment/default',
        //'Magento_Checkout/js/action/place-order',
		'Stepzerosolutions_Dps/js/action/set-payment-method',
        'Magento_Checkout/js/action/select-payment-method',
		'Magento_Checkout/js/model/payment/additional-validators',
		'Magento_Customer/js/model/customer',
    ],
    function (
        Component,
        setPaymentMethodAction,
        selectPaymentMethodAction,
		additionalValidators,
		customer
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Stepzerosolutions_Dps/payment/dps-pxpay'
            },
            /**
             * Get value of instruction field.
             * @returns {String}
             */
            getInstructions: function () {
                return window.checkoutConfig.payment.instructions[this.item.method];
            },

            /** Redirect to Dps */
            continueToDps: function () {
				if (additionalValidators.validate()) {
					setPaymentMethodAction(this.getData(), this.redirectAfterPlaceOrder, this.messageContainer);
				}

            }
        });
    }
);
