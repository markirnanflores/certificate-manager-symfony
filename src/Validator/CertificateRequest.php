<?php
namespace App\Validator;

use App\Exception\ConstraintValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Model\Http\Request\CertificateModel;

class CertificateRequest
{
    public function __construct(protected ValidatorInterface $validator) {}

    public function validate(CertificateModel $certificateModel): void
    {
        $errors = $this->validator->validate($certificateModel);
        if (count($errors)>0) {
            throw new ConstraintValidationException($errors);
        }
    }
}