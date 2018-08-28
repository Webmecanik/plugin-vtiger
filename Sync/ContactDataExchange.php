<?php
/**
 * Created by PhpStorm.
 * User: jan
 * Date: 24.8.18
 * Time: 13:50
 */

namespace MauticPlugin\MauticVtigerCrmBundle\Sync;

use MauticPlugin\IntegrationsBundle\Sync\DAO\Sync\Order\OrderDAO;
use MauticPlugin\IntegrationsBundle\Sync\DAO\Sync\Report\ObjectDAO;
use MauticPlugin\IntegrationsBundle\Sync\DAO\Sync\Report\ReportDAO;
use MauticPlugin\IntegrationsBundle\Sync\DAO\Sync\Request\RequestDAO;
use MauticPlugin\IntegrationsBundle\Sync\SyncDataExchange\SyncDataExchangeInterface;
use MauticPlugin\MauticVtigerCrmBundle\Vtiger\Repository\ContactRepository;

class ContactDataExchange implements SyncDataExchangeInterface
{
    const OBJECT_NAME = 'Contacts';

    /** @var ContactRepository */
    private $contactRepository;

    public function __construct(ContactRepository $contactRepository) {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Sync to integration
     *
     * @param RequestDAO $requestDAO
     *
     * @return ReportDAO
     */
    public function getSyncReport(RequestDAO $requestDAO)
    {
        // TODO: Implement getSyncReport() method.
    }


    public function getObjectSyncReport(ObjectDAO $requestedObject)
    {
        $fromDateTime = $requestedObject->getFromDateTime();
        $mappedFields = $requestedObject->getFields();

        $updated = $this->getReportPayload($fromDateTime, $mappedFields);

        foreach ($updated as $object) {
            // If the integration knows modified timestamps per field, use that. Otherwise, we're using the complete object's
            // last modified timestamp.
            $objectChangeTimestamp = new \DateTimeImmutable($object['last_modified']);

            $objectDAO = new ObjectDAO(self::OBJECT_NAME, $object['id'], $objectChangeTimestamp);

            foreach ($person as $field => $value) {
                // Normalize the value from the API to what Mautic needs
                $normalizedValue = $this->valueNormalizer->normalizeForMautic(self::FIELDS[$field]['type'], $value);
                $reportFieldDAO  = new FieldDAO($field, $normalizedValue);

                // If we know for certain that this specific field was modified at a specific date/time, set the change timestamp
                // on the field itself for the judge to weigh certain versus possible changes
                //$reportFieldDAO->setChangeTimestamp($fieldChangeTimestamp);

                $objectDAO->addField($reportFieldDAO);
            }

            $syncReport->addObject($objectDAO);
        }

        return $syncReport;

        // TODO: Implement getSyncReport() method.
        var_dump('get sync report'); die();
    }

    public function executeSyncOrder(OrderDAO $syncOrderDAO)
    {
        // TODO: Implement executeSyncOrder() method.
        var_dump('execute sync order'); die();

    }

    private function getReportPayload($fromDate, $mappedFields) {
        var_dump('getReportPayload');
        die();
    }
}