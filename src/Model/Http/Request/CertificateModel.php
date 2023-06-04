<?php

namespace App\Model\Http\Request;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\Validator\Constraints as Assert;

class CertificateModel
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected mixed $name;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected mixed $certificate;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    protected mixed $privateKey;

    #[Assert\Type('string')]
    protected mixed $intermediateCa;

    public function __construct(InputBag $input)
    {
        $this->name = $input->get('name', null);
        $this->certificate = $input->get('certificate', null);
        $this->privateKey = $input->get('privateKey', null);
        $this->intermediateCa = $input->get('intermediateCa', '');
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getCertificate(): mixed
    {
        return $this->certificate;
    }

    public function getPrivateKey(): mixed
    {
        return $this->privateKey;
    }

    public function getIntermediateCa(): mixed
    {
        return $this->intermediateCa;
    }
}
