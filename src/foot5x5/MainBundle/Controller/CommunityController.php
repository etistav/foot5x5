<?php

namespace foot5x5\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use foot5x5\MainBundle\Entity\Community;
use foot5x5\MainBundle\Form\CommunityType;
use foot5x5\MainBundle\Entity\Roles;

class CommunityController extends Controller
{	
	/**
	 * Management of the 'create community' view
	 *
	 * @param Request $request
	 */
	public function createAction(Request $request) {
		$community = new Community();
		$communityForm = $this->createForm(CommunityType::class, $community);
		
		$cmnRepo = $this->getDoctrine()->getRepository(Community::class);
		// $rolRepo = $this->getDoctrine()->getRepository(Roles::class);
		
		$communityForm->handleRequest($request);
		if ($communityForm->isSubmitted() && $communityForm->isValid()) {
			// Get connected user and save him as the creator of the community
			$user = $this->getUser();
			$community->setCreatorUserId($user);
			
			// Generate
			$password = $cmnRepo->generatePassword();
			$community->setPassword($password);
			
			// Save the community in db
			$em = $this->getDoctrine()->getManager();
			$em->persist($community);
			$em->flush();
			
			$role = new Roles();
			$role->setCommunityId($community);
			$role->setUserId($user);
			$role->setRoles('ROLE_ADMIN');
			$em->persist($role);
			$em->flush();
			
			// Redirect to home page
			$this->get('session')->getFlashBag()->add('success', 'Tu viens de créer la communauté '.$community->getName().' !');
			return $this->redirect($this->generateUrl('foot5x5_main_homepage'));
		}
		return $this->render(
			'foot5x5MainBundle::community_form.html.twig',
			array(
				'title' => 'Crée ta communauté foot5x5 !',
				'buttonLabel' => 'C\'est parti !',
				'community' => $community,
				'communityForm' => $communityForm->createView()
			)
		);
	}
	
	/**
	 * Management of the home page of a community
	 */
	public function homeAction() {
		
		$mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
		$rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		
		$lastResult = $resRepo->findLastMatch();
		$matchPlayers = $mplRepo->findBy(array('match' => $lastResult), array('team' => 'ASC'));
		
		$lastStandingId = $stdRepo->findLastStanding()->getId();
		$lastStanding = $stdRepo->find($lastStandingId);
		
		$players = $plrRepo->findAllActives();
		$ranks = array();
		$currentForms = array();
		$currentSeries = array();
		$globalResults = array();
		foreach ($players as $player) {
			$playerId = $player->getId();
			$ranks[$playerId] = $rnkRepo->findRankInStanding($lastStanding, $player);
			$currentForms[$playerId] = $mplRepo->getCurrentForm($player);
			$currentSeries[$playerId] = $mplRepo->getCurrentSerie($player);
			$globalResults[$playerId] = $mplRepo->getAllResultsForPlayer($player);
		}
		
		return $this->render(
				'foot5x5MainBundle::index.html.twig',
				array(
						'lastResult' => $lastResult,
						'matchPlayers' => $matchPlayers,
						'lastStanding' => $lastStanding,
						'ranks'        => $ranks,
						'currentForms' => $currentForms,
						'currentSeries' => $currentSeries,
						'globalResults' => $globalResults
				)
				);
	}
}
