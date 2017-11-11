<?php
// src/foot5x5/UserBundle/Controller/RegistrationController.php

namespace foot5x5\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use foot5x5\UserBundle\Entity\User;
use foot5x5\UserBundle\Form\UserType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
	/**
	 * Management of the 'register' view
	 *
	 * @param Request $request
	 */
	public function registerAction(Request $request)
	{
		
		// Build the form
		$user = new User();
		$formOptions = array(
				"action" => "register"
		);
		$userForm = $this->createForm(UserType::class, $user, $formOptions);
		
		$userForm->handleRequest($request);
		if ($userForm->isSubmitted() && $userForm->isValid()) {
			
			// Check if username already exists
			// $usrRepo->findOneBy($user->getUsername());
			
			// Génération d'une valeur aléatoire pour le salt
			$salt = substr(md5(time()), 0, 23);
			$user->setSalt($salt);
			
			// Encodage du mot de passe
			$factory =$this->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);
			$plainPassword = $user->getPassword();
			$password = $encoder->encodePassword($plainPassword, $user->getSalt());
			$user->setPassword($password);
			
			// Save the user
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			// TODO send email
			// ...
			
			// Automatically login after registration
			$token = new UsernamePasswordToken($user, $password, 'main');
			$this->get('security.token_storage')->setToken($token);
			$this->get('session')->set('main', serialize($token));
			
			// Redirect to welcome page with message management
			$this->get('session')->getFlashBag()->add('success', 'Le user '.$user->getUsername().' a bien été créé.');
			return $this->redirect($this->generateUrl('welcome'));
			// return $this->redirect($this->generateUrl('foot5x5_main_homepage'));
			
			//return $this->redirectToRoute('foot5x5_main_homepage');
		}
		return $this->render(
				'foot5x5UserBundle::register.html.twig',
				array(
						'userForm' => $userForm->createView(),
						'title' => 'S\'inscrire'
				)
		);
	}
	
	/**
	 * Management of the 'welcome' view
	 */
	public function welcomeAction() {
		
		$username = $this->get('security.token_storage')->getToken()->getUser()->getFirstname();
		
		return $this->render(
				'foot5x5UserBundle::welcome.html.twig',
				array(
						'title' => 'Bienvenue '.$username. ' !'
				)
				);
	}
}