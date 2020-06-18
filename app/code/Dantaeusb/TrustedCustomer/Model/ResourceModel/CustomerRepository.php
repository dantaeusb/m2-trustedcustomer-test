<?php


namespace Dantaeusb\TrustedCustomer\Model\ResourceModel;

use Dantaeusb\TrustedCustomer\Setup\InstallData;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\CustomerFactory;
use Dantaeusb\TrustedCustomer\Api\TrustedCustomerRepositoryInterface;
use Magento\Framework\Webapi\Exception;

class CustomerRepository
{
    public function afterGetById($customerId, \Magento\Customer\Api\Data\CustomerInterface $result)
    {
        $result->setEmail();

        return $result;
    }
}