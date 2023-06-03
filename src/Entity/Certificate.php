<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificateRepository::class)]
class Certificate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $certificate = null;

    #[ORM\Column(length: 255)]
    private ?string $private_key = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $intermediate_ca = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCertificate(): ?string
    {
        return $this->certificate;
    }

    public function setCertificate(string $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getPrivateKey(): ?string
    {
        return $this->private_key;
    }

    public function setPrivateKey(string $private_key): self
    {
        $this->private_key = $private_key;

        return $this;
    }

    public function getIntermediateCa(): ?string
    {
        return $this->intermediate_ca;
    }

    public function setIntermediateCa(?string $intermediate_ca): self
    {
        $this->intermediate_ca = $intermediate_ca;

        return $this;
    }
}
