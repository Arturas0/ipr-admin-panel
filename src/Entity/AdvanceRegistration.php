<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AdvanceRegistrationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdvanceRegistrationRepository::class)]
class AdvanceRegistration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: AdvanceRegistration::class)]
    private ?User $user;

    #[ORM\Column]
    private ?int $municipality_code = null;

    #[ORM\Column(nullable: true)]
    private ?int $doctor_type = null;

    #[ORM\Column(nullable: true)]
    private ?int $organisation_code = null;

    #[ORM\Column(nullable: true)]
    private ?int $profession = null;

    #[ORM\Column(nullable: true)]
    private ?int $doctor = null;

    #[ORM\Column(nullable: true)]
    private ?int $medical_service = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_to = null;

    #[ORM\Column(nullable: true)]
    private array $excluded_medical_services = [];

    #[ORM\Column(nullable: true)]
    private array $excluded_fund_types = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setUser(?UserInterface $user): void
    {
        $this->user = $user;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getMunicipalityCode(): ?int
    {
        return $this->municipality_code;
    }

    public function setMunicipalityCode(int $municipality_code): static
    {
        $this->municipality_code = $municipality_code;

        return $this;
    }

    public function getDoctorType(): ?int
    {
        return $this->doctor_type;
    }

    public function setDoctorType(?int $doctor_type): static
    {
        $this->doctor_type = $doctor_type;

        return $this;
    }

    public function getOrganisationCode(): ?int
    {
        return $this->organisation_code;
    }

    public function setOrganisationCode(?int $organisation_code): static
    {
        $this->organisation_code = $organisation_code;

        return $this;
    }

    public function getProfession(): ?int
    {
        return $this->profession;
    }

    public function setProfession(?int $profession): static
    {
        $this->profession = $profession;

        return $this;
    }

    public function getDoctor(): ?int
    {
        return $this->doctor;
    }

    public function setDoctor(?int $doctor): static
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getMedicalService(): ?int
    {
        return $this->medical_service;
    }

    public function setMedicalService(?int $medical_service): static
    {
        $this->medical_service = $medical_service;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->date_from;
    }

    public function setDateFrom(?\DateTimeInterface $date_from): static
    {
        $this->date_from = $date_from;

        return $this;
    }

    public function getDateTo(): ?\DateTimeInterface
    {
        return $this->date_to;
    }

    public function setDateTo(?\DateTimeInterface $date_to): static
    {
        $this->date_to = $date_to;

        return $this;
    }

    public function getExcludedMedicalServices(): array
    {
        return $this->excluded_medical_services;
    }

    public function setExcludedMedicalServices(?array $excluded_medical_services): static
    {
        $this->excluded_medical_services = $excluded_medical_services;

        return $this;
    }

    public function getExcludedFundTypes(): array
    {
        return $this->excluded_fund_types;
    }

    public function setExcludedFundTypes(?array $excluded_fund_types): static
    {
        $this->excluded_fund_types = $excluded_fund_types;

        return $this;
    }
}
