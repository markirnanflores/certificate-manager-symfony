<?php
namespace App\Model\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationResponse extends JsonResponse
{
    public function __construct(
        ConstraintViolationList $violationList,
        int $status = 400,
        array $headers = [],
        bool $json = false
    ) {
        parent::__construct(
            ['errors' => $this->getErrors($violationList)],
            $status,
            $headers,
            $json
        );
    }

    protected function getErrors(ConstraintViolationList $violationList): array
    {
        $arr = [];
        foreach($violationList as $violation) {
            $arr[] = [
                $violation->getPropertyPath() => $violation->getMessage()
            ];
        }
        return $arr;
    }
}