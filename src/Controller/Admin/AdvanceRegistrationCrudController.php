<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AdvanceRegistration;
use App\Security\AdvanceRegistrationVoter;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AdvanceRegistrationCrudController extends AbstractCrudController
{
    private HttpClientInterface $httpClient;

    public function __construct()
    {
        $this->httpClient = HttpClient::create();
    }

    public static function getEntityFqcn(): string
    {
        return AdvanceRegistration::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('advance registration')
            ->setEntityLabelInPlural('Advance registrations')
            ->setEntityPermission(AdvanceRegistrationVoter::EDIT)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('municipality_code')
            ->setLabel('Municipality')
            ->setChoices($this->getMunicipalityChoices());

        yield ChoiceField::new('doctor_type')
            ->setLabel('Specialist')
            ->setChoices($this->getDoctorTypeChoices());

        yield ChoiceField::new('organisation_code')
            ->setLabel('Organisation')
            ->setChoices($this->getOrganisationChoices());

        yield ChoiceField::new('profession')
        ->setLabel('Healthcare service')
        ->setChoices($this->getHealthCareServiceChoices());

        yield IntegerField::new('doctor');

        yield IntegerField::new('medical_service');

        yield BooleanField::new('status')
        ->setLabel('Active');
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters,
    ): QueryBuilder {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->innerJoin("$rootAlias.user", "u");
        $queryBuilder->andWhere("u.id = :user_id");
        $queryBuilder->setParameter('user_id', $this->getUser()->getId());

        return $queryBuilder;
    }

    public function createEntity(string $entityFqcn): AdvanceRegistration
    {
        $registration = new AdvanceRegistration();
        $registration->setUser($this->getUser());

        return $registration;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ;
    }

    private function getMunicipalityChoices(): \Closure
    {
        return function () {
            $data = $this->httpClient
                ->request('GET', 'https://ipr.esveikata.lt/api/searchesNew/municipalities')
                ->toArray();

            $choices = [];
            foreach ($data['data'] as $item) {
                $choices[$item['pavadinimas']] = $item['admId'];
            }

            return $choices;
        };
    }

    private function getDoctorTypeChoices(): \Closure
    {
        return function () {
            $data = $this->httpClient
                ->request('GET', 'https://ipr.esveikata.lt/api/searchesNew/professions')
                ->toArray();

            $choices = [];
            foreach ($data['data'] as $item) {
                $choices[$item['name']] = $item['code'];
            }

            return $choices;
        };
    }

    private function getOrganisationChoices(): \Closure
    {
        return function () {
            $data = $this->httpClient
                ->request('GET', 'https://ipr.esveikata.lt/api/searchesNew/institutions')
                ->toArray();

            $choices = [];
            foreach ($data['data'] as $item) {
                $choices[$item['istgPavadinimas']] = $item['istgId'];
            }

            return $choices;
        };
    }

    private function getHealthCareServiceChoices(): \Closure
    {
        return function () {
            $data = $this->httpClient
                ->request('GET', 'https://ipr.esveikata.lt/api/searchesNew/healthcare-filter-services')
                ->toArray();

            $choices = [];
            foreach ($data['data'] as $item) {
                $choices[$item['name']] = $item['id'];
            }

            return $choices;
        };
    }
}
