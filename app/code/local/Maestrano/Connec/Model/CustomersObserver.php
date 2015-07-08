<?php

class Maestrano_Connec_Model_CustomersObserver
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function customerSaveAfter(Varien_Event_Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();

        $observerLock = $customer->getObserverLock();
        if ($observerLock) {
            Mage::log("## Maestrano_Connec_Model_CustomersObserver::customerSaveAfter - Observers are locked for customer " . $customer->getId());
            return;
        }

        // Save customer in connec!
        Mage::log('## Maestrano_Connec_Model_CustomersObserver::customerSaveAfter: processing customer: ' . $customer->getId());
        /** @var Maestrano_Connec_Helper_Customers $customerMapper */
        $mapper = Mage::helper('mnomap/customers');
        $mapper->processLocalUpdate($customer);
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function customerDeleteAfter(Varien_Event_Observer $observer)
    {
        $customer = $observer->getEvent()->getProduct();

        $observerLock = $customer->getObserverLock();
        if ($observerLock) {
            Mage::log("## Maestrano_Connec_Model_CustomersObserver::customerDeleteAfter - Observers are locked for customer " . $customer->getId());
            return;
        }

        // Delete customer in connec_mnomapid!
        Mage::log('## Maestrano_Connec_Model_CustomersObserver::customerDeleteAfter: deleting customer ' . $customer->getId());
        /** @var Maestrano_Connec_Helper_Customers $customerMapper */
        $customerMapper = Mage::helper('mnomap/customers');
        $customerMapper->processLocalUpdate($customer, false, true);
    }
}
