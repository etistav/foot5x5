<?php

namespace foot5x5\MainBundle\Controller;


use foot5x5\MainBundle\Entity\Note;
use foot5x5\MainBundle\Entity\Roles;
use foot5x5\UserBundle\Entity\User;
use foot5x5\MainBundle\Form\NoteType;
use foot5x5\MainBundle\Form\RandomDrawType;
use foot5x5\MainBundle\Form\UploadProfilePicType;
use foot5x5\UserBundle\Form\UserType;
use foot5x5\UserBundle\Form\UserPwdType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use foot5x5\MainBundle\Entity\Community;
use foot5x5\MainBundle\Form\CommunityType;
use foot5x5\MainBundle\Entity\Param;

class MainController extends Controller
{
	/**
	 * Management of the home page
	 * 
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function indexAction()
	{
		// Check if user already authenticated
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirect($this->generateUrl('community_home'));
		} else {
			return $this->redirect($this->generateUrl('home'));
		}
	}

	public function homeAction()
	{
		// Check if user already authenticated
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->redirect($this->generateUrl('community_home'));
		} 
		return $this->render(
			'foot5x5MainBundle::home.html.twig',
			array(
				'title' => 'Bienvenue sur foot5x5.fr !'
			)
		);
	}
	
	/**
	 * Management of the 'welcome' view
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function welcomeAction()
	{
		// Init community variables in session
		$this->get('session')->remove('community');
		$this->get('session')->remove('community_name');

		// Get isCommunityCreationAllowed parameter
		$isCommunityCreationAllowed = false;
		$prmRepo = $this->getDoctrine()->getRepository(Param::class);
		$isCommunityCreationAllowedValue = $prmRepo->findOneBy(array('name' => "isCommunityCreationAllowed"))->getValue();
		if ($isCommunityCreationAllowedValue == "Y") {
			$isCommunityCreationAllowed = true;
		}
		
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$username = $user->getFirstname();
		
		$communities = array();
		$userRoles = $user->getUserRoles();
		foreach ($userRoles as $userRole) {
			$communities[] = $userRole->getCommunity();
		}
		
		return $this->render(
			'foot5x5UserBundle::welcome.html.twig',
			array(
				'title' => 'Bienvenue '.$username.' !',
				'username' => $username,
				'communities' => $communities,
				'isCommunityCreationAllowed' => $isCommunityCreationAllowed
			)
		);
    }

    /**
     * Management of the 'user profile' view
	 *
	 * @param Request $request
     */
    public function profileAction(Request $request) {

		$user = $this->getUser();

		// Management of the "edit personal info" form
		$formOptions = array(
			"form_situation" => "editProfileInfo"
		);
		$userForm = $this->createForm(UserType::class, $user, $formOptions);
		$userForm->handleRequest($request);
		if ($userForm->isSubmitted()) {
			$em = $this->getDoctrine()->getManager();
			if ($userForm->isValid()) {
				// Ecriture du user en BDD
				$em->persist($user);
				$em->flush();
				
				// Gestion d'un message d'info
				$this->get('session')->getFlashBag()->add('success', 'Vos infos personnelles ont bien été modifiées.');
			} else {
				// Reset user information
				$em->refresh($user);
			}
		}

		// Management of the "Upload profile pic" form
		$uploadForm = $this->createForm(UploadProfilePicType::class, $user);
		$uploadForm->handleRequest($request);
		if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
			// Save the user
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();

			// Gestion d'un message d'info
			$this->get('session')->getFlashBag()->add('success', 'Votre photo de profil a bien été mise à jour.');
		}

		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		$isInCommunity = true;
		if (!isset($communityId)) {
			// Management of the view rendering from outside of any community
			$isInCommunity = false;
			return $this->render(
				'foot5x5MainBundle::profile.html.twig',
				array(
					'user' => $user,
					'uploadForm' => $uploadForm->createView(),
					'uploadButtonLabel' => 'Upload',
					'userForm' => $userForm->createView(),
					'editInfoButtonLabel' => 'Modifier',
					'isInCommunity' => $isInCommunity
				)
			);
		}

		// Management of the view rendering from inside a community
        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		$rolRepo = $this->getDoctrine()->getRepository(Roles::class);
		$cmnRepo = $this->getDoctrine()->getRepository(Community::class);
		
		$community = $cmnRepo->find($communityId);
		$player = $rolRepo->getPlayerForCommunity($user, $community);

		$lastStanding = $stdRepo->findLastStanding($communityId);
		
		// Initialization of parameters passed to twig view
		$rank = "Non classé";
		$currentForm = "-";
		$lastMatch = NULL;
		$resultForPlayer = "-";
		$bestRank = "-";
		$worstRank = "-";
		$nbTitles = "-";
		$nbPodiums = "-";
		$nbRelegations = "-";
		$nbTimesLast = "-";

		if (is_null($player)) {
			$this->get('session')->getFlashBag()->add('warning', 'Attention! Le profil n\'est rattaché à aucun joueur de cette communauté.');	
		} else {
			if (!is_null($lastStanding)) {
				$rank = $rnkRepo->findRankInStanding($lastStanding, $player);
			}
			$currentForm = $mplRepo->getCurrentForm($player);
			$lastMatch = $mplRepo->getLastMatch($player);
			if (!is_null($lastMatch)) {
				$resultForPlayer = $mplRepo->getResultForPlayer($lastMatch, $player);
			}
	
			$bestRank = $rnkRepo->findBestRankEver($player);
			$worstRank = $rnkRepo->findWorstRankEver($player);
			$nbTitles = $rnkRepo->howManyTitlesForPlayer($player);
			$nbPodiums = $rnkRepo->howManyPodiumsForPlayer($player);
			$nbRelegations = $rnkRepo->howManyRelegationsForPlayer($player);
			$nbTimesLast = $rnkRepo->howManyTimesLastForPlayer($player);
		}

        return $this->render(
            'foot5x5MainBundle::profile.html.twig',
            array(
				'user' => $user,
				'player' => $player,
                'rank' => $rank,
                'currentForm' => $currentForm,
                'lastMatch' => $lastMatch,
                'resultForPlayer' => $resultForPlayer,
                'bestRank' => $bestRank,
                'worstRank' => $worstRank,
                'nbTitles' => $nbTitles,
                'nbPodiums' => $nbPodiums,
                'nbRelegations' => $nbRelegations,
                'nbTimesLast' => $nbTimesLast,
	            'uploadForm' => $uploadForm->createView(),
				'uploadButtonLabel' => 'Upload',
				'userForm' => $userForm->createView(),
				'editInfoButtonLabel' => 'Modifier',
				'isInCommunity' => $isInCommunity
            )
        );
    }

    /**
     * Management of the 'edit password' view
     *
     * @param Request $request
     */
    public function editPwdAction(Request $request) {
        
	    	// Retrieve community ID from session
	    	$communityId = $this->get('session')->get('community');
	    	if (!isset($communityId)) {
	    		return $this->redirect($this->generateUrl('welcome'));
	    	}
    		$user = $this->getUser();
        $userPwdForm = $this->createForm(UserPwdType::class, $user);

        $userPwdForm->handleRequest($request);
        if ($userPwdForm->isSubmitted() && $userPwdForm->isValid()) {
			// Génération d'une valeur aléatoire pour le salt
			$salt = substr(md5(time()), 0, 23);
			$user->setSalt($salt);
			
			// Encodage du mot de passe
			$factory =$this->get('security.encoder_factory');
			$encoder = $factory->getEncoder($user);
			$plainPassword = $user->getPassword();
			$password = $encoder->encodePassword($plainPassword, $user->getSalt());
			$user->setPassword($password);
			
			// Ecriture du user en BDD
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			
			// Redirection sur la page d'admin avec gestion du message d'info
			$this->get('session')->getFlashBag()->add('success', 'Ton mot de passe a bien été modifié.');
			return $this->redirect($this->generateUrl('myprofile'));
        }
        return $this->render(
            'foot5x5MainBundle::userpwd_form.html.twig',
            array(
                'title' => 'Modifier Mot de Passe',
                'buttonLabel' => 'Enregistrer',
                'user' => $user,
                'userPwdForm' => $userPwdForm->createView()
            )
        );
    }
    
    /**
     * Management of the 'create community' view
     *
     * @param Request $request
     */
    public function createCommunityAction(Request $request) {
    		$community = new Community();
		$communityForm = $this->createForm(CommunityType::class, $community);
		var_dump($community->getPassword());
		
		$communityForm->handleRequest($request);
		if ($communityForm->isSubmitted() && $communityForm->isValid()) {
			// Get connected user and save him as the creator of the community
			$user = $this->getUser();
			$community->setCreatorUserId($user);
			
			// Save the community in db
			$em = $this->getDoctrine()->getManager();
			$em->persist($community);
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
}
