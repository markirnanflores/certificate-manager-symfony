<?php
namespace App\Exception;

use \RuntimeException;
use \Throwable;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintValidationException extends RuntimeException
{
    public function __construct(
        protected ConstraintViolationListInterface $list,
        string $message = "",
        $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->list;
    }
}