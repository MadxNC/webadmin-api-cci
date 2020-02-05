<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Groupe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $roles, $group]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setRoles($roles);
            $user->setGroupe($group);
            $manager->persist($group);
            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }

    private function getUserData(): array
    {
        $group = new Groupe();
        $group->setName("ADMIN");
        $group->setIsActive(true);
        $group->setRole("ROLE_ADMIN");
        $group->setNiveau(99);
        return [
            // $userData = [$username, $password,$roles];
            ['larry_admin', '297997', ['ROLE_ADMIN'], $group],
            ['larry_user', '297997', ['ROLE_ADMIN'], $group],
            ['louis_admin', '297997', ['ROLE_USER'], $group],
        ];
    }
}
