<?php

namespace foot5x5\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use foot5x5\MainBundle\Entity\Community;
use foot5x5\MainBundle\Entity\Note;
use foot5x5\MainBundle\Form\CommunityType;
use foot5x5\MainBundle\Form\NoteType;
use foot5x5\MainBundle\Form\RandomDrawType;
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
			$user->setCommunity($community);
			
			// Generate
			$password = $cmnRepo->generatePassword();
			$community->setPassword($password);
			
			// Save the community in db
			$em = $this->getDoctrine()->getManager();
			$em->persist($community);
			$em->flush();
			
			$role = new Roles();
			$role->setCommunity($community);
			$role->setUser($user);
			$role->setRole('ROLE_ADMIN');
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
	 * Selection of a community
	 * 
	 * @param Request $request
	 * @param integer $id community ID
	 */
	public function selectAction(Request $request, $id) {
		
		$cmnRepo = $this->getDoctrine()->getRepository(Community::class);
		$community = $cmnRepo->find($id);

		$this->get('session')->set('community', $id);
		$this->get('session')->set('community_name', $community->getName());
		return $this->redirect($this->generateUrl('community_home'));
	}
	
	/**
	 * Management of the home page of a community
	 * 
	 * @param Request $request
	 */
	public function homeAction(Request $request) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
		$rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		$cmnRepo = $this->getDoctrine()->getRepository(Community::class);
		
		$community = $cmnRepo->find($communityId);
		
		// Retrieve the last result for the community
		$lastResult = $resRepo->findLastMatch($communityId);
		if (isset($lastResult)) {
			$matchPlayers = $mplRepo->findBy(array('match' => $lastResult), array('team' => 'ASC'));
		} else {
			$matchPlayers = array();
		}
		
		// Retrieve the last standing for the community
		$lastStanding = $stdRepo->findLastStanding($communityId);
		if (isset($lastStanding)) {
			$lastStanding = $stdRepo->find($lastStanding->getId());
		}
		
		$players = $plrRepo->findAllActives($communityId);
		$ranks = array();
		$currentForms = array();
		$currentSeries = array();
		$globalResults = array();
		if (isset($lastStanding)) {
			foreach ($players as $player) {
				$playerId = $player->getId();
				$ranks[$playerId] = $rnkRepo->findRankInStanding($lastStanding, $player);
				$currentForms[$playerId] = $mplRepo->getCurrentForm($player);
				$currentSeries[$playerId] = $mplRepo->getCurrentSerie($player);
				$globalResults[$playerId] = $mplRepo->getAllResultsForPlayer($player);
			}
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
	
	/**
	 * Management of the 'results' view
	 *
	 * @param Request $request
	 */
	public function resultsAction(Request $request) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
		$rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		
		
		$trimesters = $resRepo->listAllTrimesters($communityId);
		if (empty($trimesters)) {
			return $this->redirect($this->generateUrl('community_home'));
		}
		
		// Populate trimester dropdown
		$trimNames = array();
		$trimIds = array();
		foreach ($trimesters as $trimester) {
			$trimName = 'T0'.$trimester['trimester'].' - '.$trimester['year'];
			$trimId = $trimester['year'].$trimester['trimester'];
			$trimNames[] = $trimName;
			$trimIds[] = $trimId;
		}
		$trimNames = array_combine($trimNames, $trimIds);
		$trimesterForm = $this->createFormBuilder()
		->add('stdCombo', ChoiceType::class, array(
				'choices' => $trimNames,
				'choices_as_values' => true,
				'label' => 'Trimestre'
		))
		->getForm();
		
		$trimesterForm->handleRequest($request);
		if ($trimesterForm->isSubmitted()) {
			if ($trimesterForm->isValid()) {
				$idTrimester = $trimesterForm->get('stdCombo')->getData();
				$currentYear = substr($idTrimester, 0, 4);
				$currentTrimester = substr($idTrimester, 4, 1);
			}
		} else {
			$lastResult = $resRepo->findLastMatch($communityId);
			$currentYear = $lastResult->getYear();
			$currentTrimester = $lastResult->getTrimester();
		}
		
		$results = $resRepo->listAllByTrimester($currentYear, $currentTrimester);
		
		$players = $plrRepo->findAllActives($communityId);
		$lastStandingId = $stdRepo->findLastStanding($communityId)->getId();
		$lastStanding = $stdRepo->find($lastStandingId);
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
			'foot5x5MainBundle::results.html.twig',
			array(
				'results' => $results,
				'currentYear' => $currentYear,
				'currentTrimester' => $currentTrimester,
				'trimesterForm' => $trimesterForm->createView(),
				'players'      => $players,
				'ranks'        => $ranks,
				'currentForms' => $currentForms,
				'currentSeries' => $currentSeries,
				'globalResults' => $globalResults
			)
		);
	}
	
	/**
	 * Management of the 'standings' view
	 *
	 * @param Request $request
	 */
	public function standingsAction(Request $request) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		$standings = $stdRepo->findByCommunity($communityId);
		
		if (empty($standings)) {
			return $this->redirect($this->generateUrl('community_home'));
		}
		
		$lastStanding = $stdRepo->findLastStanding($communityId);
		$idStanding = $lastStanding->getId();
		$standingsName = array();
		$standingsId = array();
		$standingsNames = array();
		foreach ($standings as $standing) {
			$standingsName[] = $standing->getName();
			$standingsId[] = $standing->getId();
		}
		$standingsNames = array_combine($standingsName, $standingsId);
		$standingForm = $this->createFormBuilder()
		->add('stdCombo', ChoiceType::class, array(
				'choices' => $standingsNames,
				'choices_as_values' => true,
				'label' => 'Choix'
		))
		->getForm();
		
		$standingForm->handleRequest($request);
		if ($standingForm->isSubmitted() && $standingForm->isValid()) {
			$idStanding = $standingForm->get('stdCombo')->getData();
		}
		
		$standing = $stdRepo->find($idStanding);
		
		return $this->render(
			'foot5x5MainBundle::standing.html.twig',
			array(
				'standing' => $standing,
				'standingForm' => $standingForm->createView()
			)
		);
	}
	
	/**
	 * Management of the 'players' view
	 */
	public function playersAction()
	{
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
		$stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
		
		$players = $plrRepo->findAllActives($communityId);
		$lastStanding = $stdRepo->findLastStanding($communityId);
		
		$ranks = array();
		$currentForms = array();
		$currentSeries = array();
		$lastMatches = array();
		$resultsForPlayer = array();
		$globalResults = array();
		$ranksPerPeriod = array();
		$bestRanks = array();
		$worstRanks = array();
		$nbTitles = array();
		$nbPodiums = array();
		$nbRelegations = array();
		$nbTimesLast = array();
		
		foreach ($players as $player) {
			$playerId = $player->getId();
			$ranks[$playerId] = $rnkRepo->findRankInStanding($lastStanding, $player);
			$currentForms[$playerId] = $mplRepo->getCurrentForm($player);
			$currentSeries[$playerId] = $mplRepo->getCurrentSerie($player);
			$lastMatches[$playerId] = $mplRepo->getLastMatch($player);
			$resultsForPlayer[$playerId] = $mplRepo->getResultForPlayer($lastMatches[$playerId], $player);
			$globalResults[$playerId] = $mplRepo->getAllResultsForPlayer($player);
			
			$ranksPerPeriod[$playerId] = $rnkRepo->getAllRankings($player);
			
			$bestRanks[$playerId] = $rnkRepo->findBestRankEver($player);
			$worstRanks[$playerId] = $rnkRepo->findWorstRankEver($player);
			$nbTitles[$playerId] = $rnkRepo->howManyTitlesForPlayer($player);
			$nbPodiums[$playerId] = $rnkRepo->howManyPodiumsForPlayer($player);
			$nbRelegations[$playerId] = $rnkRepo->howManyRelegationsForPlayer($player);
			$nbTimesLast[$playerId] = $rnkRepo->howManyTimesLastForPlayer($player);
		}
		
		return $this->render(
			'foot5x5MainBundle::players.html.twig',
			array(
				'players'      => $players,
				'ranks'        => $ranks,
				'currentForms' => $currentForms,
				'currentSeries' => $currentSeries,
				'lastMatches' => $lastMatches,
				'resultsForPlayer' => $resultsForPlayer,
				'globalResults' => $globalResults,
				'ranksPerPeriod' => $ranksPerPeriod,
				'bestRanks' => $bestRanks,
				'worstRanks' => $worstRanks,
				'nbTitles' => $nbTitles,
				'nbPodiums' => $nbPodiums,
				'nbRelegations' => $nbRelegations,
				'nbTimesLast' => $nbTimesLast
			)
		);
	}

	/**
	 * Management of the 'random draw' view
	 *
	 * @param Request $request
	 */
	public function randomDrawAction(Request $request) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
		$players = $plrRepo->findAllActives($communityId);
		$matchPlayers = array();
		$selectedPlayersList = array();
		
		$randomDrawForm= $this->createForm(RandomDrawType::class, $players);
		
		$randomDrawForm->handleRequest($request);
		if ($randomDrawForm->isSubmitted() && $randomDrawForm->isValid()) {
			$selectedPlayersString = $randomDrawForm->get('selectedPlayers')->getData();
			$selectedPlayersList = explode(",", $selectedPlayersString);
			$nbSelectedPlayers = count($selectedPlayersList);
			if ($nbSelectedPlayers == 10) {
				$IsRandomOK = false;
				$nbDraw=0;
				$selectedPlayers = array();
				foreach ($selectedPlayersList as $selectedPlayerName) {
					$selectedPlayers[] = $plrRepo->findOneByName($selectedPlayerName);
				}
				while ((!$IsRandomOK) or ($nbDraw >= 10)) {
					$nbDraw++;
					$sumAvgTeamA = 0;
					$sumAvgTeamB = 0;
					$matchPlayers = $mplRepo->randomDraw($selectedPlayers);
					for ($i=0; $i < 10; $i++) {
						$team = $matchPlayers[$i]->getTeam();
						switch ($team) {
							case 'A':
								$sumAvgTeamA += $matchPlayers[$i]->getPlayer()->getValAvg();
								break;
							case 'B':
								$sumAvgTeamB += $matchPlayers[$i]->getPlayer()->getValAvg();
								break;
							default:
								$this->get('session')->getFlashBag()->add('warning', 'Pas de team définie pour '.$matchPlayers[$i]->getPlayer()->getName());
								break;
						}
					}
					if (abs($sumAvgTeamA-$sumAvgTeamB) <= 2) {
						$IsRandomOK = true;
					}
				}
				$this->get('session')->getFlashBag()->add('success', 'Tirage au sort effectué!');
			} else {
				if ($nbSelectedPlayers > 10) {
					$this->get('session')->getFlashBag()->add('warning', 'Trop de joueurs sélectionnés : '.$nbSelectedPlayers);
				} else {
					$this->get('session')->getFlashBag()->add('warning', 'Nombre de joueurs sélectionnés insuffisant : '.$nbSelectedPlayers);
				}
			}
		}
		
		return $this->render(
			'foot5x5MainBundle::randomDraw.html.twig',
			array(
				'title' => 'Tirage au sort',
				'randomDrawForm' => $randomDrawForm->createView(),
				'players' => $players,
				'matchPlayers' => $matchPlayers,
				'selectedPlayersList' => $selectedPlayersList
			)
		);
	}
	
	/**
	 * Management of the 'finance' view
	 */
	public function financesAction() {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$trnRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Transaction');
		
		$debts = $plrRepo->findAllWithDebts($communityId);
		$credits = $plrRepo->findAllWithCredits($communityId);
		$totalDebts = $plrRepo->calcTotalDebts($communityId);
		$totalCredits = $plrRepo->calcTotalCredits($communityId);
		$transactions = $trnRepo->listLast($communityId, 10);
		return $this->render(
			'foot5x5MainBundle::finance.html.twig',
			array(
				'debts' => $debts,
				'credits' => $credits,
				'totalDebts' => $totalDebts,
				'totalCredits' => $totalCredits,
				'transactions' => $transactions
			)
		);
	}
	
	/**
	 * Management of the 'notes' view
	 * 
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function notesAction() {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$user = $this->getUser();
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		$players = $plrRepo->findNotesFromUser($communityId, $user);
		
		return $this->render(
			'foot5x5MainBundle::notes.html.twig',
			array(
				'user' => $user,
				'players' => $players
			)
		);
	}

	/**
	 * Management of the 'edit notes' view
	 *
	 * @param Request $request
	 * @param integer $id id du joueur modifié
	 */
	public function editNoteAction(Request $request, $id) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$user = $this->getUser();
		$notRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Note');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		
		$player = $plrRepo->find($id);
		$note = $notRepo->findNoteFromUser($user, $player);
		
		// Gestion du cas où la note n'existe pas encore en bdd
		if (is_null($note)) {
			$note = new Note();
			$note->setPlayer($player);
			$note->setEvaluator($user);
		}
		
		// Création du formulaire associé
		$noteForm = $this->createForm(NoteType::class, $note);
		
		$noteForm->handleRequest($request);
		if ($noteForm->isSubmitted() && $noteForm->isValid()) {
			// MAJ des notes du joueur pour l'utilisateur connecté
			$em = $this->getDoctrine()->getManager();
			$em->persist($note);
			$em->flush();
			
			// MAJ des notes globales du joueur
			$player = $notRepo->updateNotesPlayer($player);
			$em->persist($player);
			$em->flush();
			
			// Redirection sur la page d'admin avec gestion du message d'info
			$this->get('session')->getFlashBag()->add('success', 'Les notes de '.$player->getName().' ont bien été modifiées.');
			return $this->redirect($this->generateUrl('notes'));
		}
		return $this->render(
			'foot5x5MainBundle::note_form.html.twig',
			array(
				'title' => 'Notes '.$player->getName(),
				'buttonLabel' => 'Enregistrer',
				'note' => $note,
				'noteForm' => $noteForm->createView()
			)
		);
	}

	/**
	 * Handle the removal of players' notes
	 *
	 * @param integer $id id du joueur modifié
	 */
	public function deleteNoteAction($id) {
		
		// Retrieve community ID from session
		$communityId = $this->get('session')->get('community');
		if (!isset($communityId)) {
			return $this->redirect($this->generateUrl('welcome'));
		}
		
		$user = $this->getUser();
		$notRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Note');
		$plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
		
		$player = $plrRepo->find($id);
		$note = $notRepo->findNoteFromUser($user, $player);
		
		// Gestion du cas où la note n'existe pas encore en bdd
		if (is_null($note)) {
			$messageType = 'warning';
			$message = 'Tu n\'as pas encore noté '.$player->getName().'.';
		} else {
			// Suppression du joueur en BDD
			$em = $this->getDoctrine()->getManager();
			$em->remove($note);
			$em->flush();
			
			// MAJ des notes globales du joueur
			$player = $notRepo->updateNotesPlayer($player);
			$em->persist($player);
			$em->flush();
			
			$messageType = 'success';
			$message = 'Tes notes pour '.$player->getName().' a bien été supprimée.';
		}
		
		// Redirection sur la page des notes avec un message d'info
		$this->get('session')->getFlashBag()->add($messageType, $message);
		return $this->redirect($this->generateUrl('notes'));
	}
}
