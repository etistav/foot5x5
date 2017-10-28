<?php
// src/foot5x5/UserBundle/DataFixtures/ORM/Users.php

namespace foot5x5\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use foot5x5\MainBundle\Entity\Player;
use foot5x5\UserBundle\Entity\User;

class Users implements FixtureInterface
{	
	public function load(ObjectManager $manager) {
		// Noms des utilisateurs à créer
		$noms = array('eti', 'maiki', 'benoit', 'tober', 'max', 'xav', 'jon');

		foreach ($noms as $i => $nom) {
			
			$users[$i] = new User;
			//$player = new Player;

			$users[$i]->setUsername($nom);
			$users[$i]->setPassword($nom);
			$users[$i]->setSalt('');
			$users[$i]->setRoles(array());

			$manager->persist($users[$i]);
		}
		$manager->flush();
	}
}
