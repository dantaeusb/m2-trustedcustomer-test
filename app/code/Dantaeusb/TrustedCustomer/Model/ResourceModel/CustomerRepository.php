<?php


namespace Dantaeusb\TrustedCustomer\Model\ResourceModel;

class CustomerRepository
{
    public function afterGetById($customerId, \Magento\Customer\Api\Data\CustomerInterface $result)
    {
        $faker = \Faker\Factory::create();

        $result->setEmail($faker->email);

        return $result;
    }
}