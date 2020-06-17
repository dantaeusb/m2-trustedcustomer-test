<?php


namespace Dantaeusb\TrustedCustomer\Observer;

use Dantaeusb\TrustedCustomer\Setup\InstallData;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Customer\Model\Customer;

class TrustedCustomer implements ObserverInterface
{
    /*public function __construct()
    {

    }*/

    /**
     * Handle customer_register_success event
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Customer $customer */
        $customer = $observer->getData('customer');
        $customerEmail = $customer->getEmail();

        $isCustomerTrusted = mb_substr($customerEmail, 0, 1) === 'r';
        $customer->setData(InstallData::TRUSTED_ATTRIBUTE_CODE, $isCustomerTrusted);

        $customer->getResource()->saveAttribute($customer, InstallData::TRUSTED_ATTRIBUTE_CODE);
    }
}