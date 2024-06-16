<?php

namespace App\Service\MassActions;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class MassDeleteService
{
    protected const VALIDATE_PARAMS = [
        'selectedRecords' => 'Missing selectedRecords parameter or value not provided',
        'entity' => 'Missing entity parameter or value not provided',
    ];

    protected const ENTITY_CLASS_NAMESPACE = 'App\Entity';

    public function __construct(protected array $requestBody, protected EntityManagerInterface $em)
    {}

    public function process(): JsonResponse
    {
        $validationResult = $this->validateRequest();
        if (!empty($validationResult)) {
            return $validationResult;
        }
        $entityName = $this->requestBody['entity'];
        $ids = "(" . implode(",", $this->requestBody['selectedRecords']) . ")";

        try {
            $connection = $this->em->getConnection();
            $connection->beginTransaction();
            $connection->executeQuery(
                "DELETE FROM " 
                . $this->em->getClassMetadata(static::ENTITY_CLASS_NAMESPACE . "\\" . $entityName)->getTableName() 
                . " WHERE id IN " . $ids
            );
            $connection->commit();
        } catch (Exception $exception) {
            $this->em->getConnection()->rollBack();
            throw new Exception($exception->getMessage(), 500);
        } finally {
            if ($this->em->getConnection()->isConnected()) {
                $this->em->getConnection()->close();
            }
        }

        return new JsonResponse(
            'Records successfully deleted!', 204
        );
    }

    protected function validateRequest(): JsonResponse | null
    {
        if (empty($this->requestBody)) {
            return new JsonResponse('Missing request body', 400);
        }
        $errorMessage = '';
        foreach (static::VALIDATE_PARAMS as $param => $invalidMessage) {
            if (!isset($this->requestBody[$param]) || empty($this->requestBody[$param])) {
                $errorMessage = implode("\n", [$errorMessage, $invalidMessage]);
            }
        }
        return !empty($errorMessage) ? new JsonResponse($errorMessage, 400) : null;
    }
}
