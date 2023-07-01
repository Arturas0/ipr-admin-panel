<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\AdvanceRegistration;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AdvanceRegistrationVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, [self::EDIT, self::VIEW])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

       return is_null($subject) || $user === $subject->getUser();
    }
}
