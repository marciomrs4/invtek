<?php

/**
 * Created by PhpStorm.
 * User: marcio
 * Date: 17/03/16
 * Time: 18:50
 */
class LoadUser implements \Doctrine\Common\DataFixtures\FixtureInterface, \Symfony\Component\DependencyInjection\ContainerAwareInterface
{


    private $container;
    /**
     * Sets the container.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $usuario1 = new \MRS\UserBundle\Entity\User();

        $usuario1->setUsername('admin')
            ->setPassword($this->encodePassword($usuario1,'admin'))
            ->setIsActive(true)
            ->setRoles(array('ROLE_SUPER_ADMIN','ROLE_ADMIN','ROLE_USER','ROLE_BLA_BLA_BLA'))
            ->setEmail('admin@mrs.com')
            ->setPlainPassword('admin');

        $usuario2 = new \MRS\UserBundle\Entity\User();

        $usuario2->setUsername('user')
            ->setPassword($this->encodePassword($usuario1,'user'))
            ->setIsActive(true)
            ->setRoles(array('ROLE_USER'))
            ->setEmail('user@mrs.com')
            ->setPlainPassword('user');

        $manager->persist($usuario1);
        $manager->persist($usuario2);

        $manager->flush();

    }

    private function encodePassword($userObject, $plainPassord)
    {
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userObject);

        return $encoder->encodePassword($plainPassord, $userObject->getSalt());
    }

}