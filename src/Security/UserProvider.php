<?php
// src/Security/UserProvider.php
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByUsername($username)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException();
        }

        // Affecter un rôle spécifique en fonction de l'adresse e-mail de l'utilisateur
        if (strpos($user->getEmail(),'@supadmin.tn')!==false) {
            $user->setRoles(['ROLE_SUPER_ADMIN']);
        } else if (strpos($user->getEmail(),'@admin.tn')!==false){
            $user->setRoles(['ROLE_ADMIN']);
        }
        else{
            $user->setRoles(['ROLE_USER']);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
