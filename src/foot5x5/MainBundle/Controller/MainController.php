<?php

namespace foot5x5\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use foot5x5\MainBundle\Entity\Note;
use foot5x5\MainBundle\Form\NoteType;
use foot5x5\MainBundle\Form\RandomDrawType;
use foot5x5\UserBundle\Form\UserPwdType;

class MainController extends Controller
{
    public function indexAction() {

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

    public function resultsAction() {

        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        $rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');

        $trimesters = $resRepo->listAllTrimesters();
        // Alimentation de la combobox trimestre
        $trimNames = array();
        $trimIds = array();
        foreach ($trimesters as $trimester) {
            $trimName = 'T0'.$trimester['trimester'].' - '.$trimester['year'];
            $trimId = $trimester['year'].$trimester['trimester'];
            $trimNames[] = $trimName;
            $trimIds[] = $trimId;
        }
        $trimNames = array_combine($trimIds, $trimNames);
        $trimesterForm = $this->createFormBuilder()
            ->add('stdCombo', 'choice', array(
                'choices' => $trimNames,
                'label' => 'Trimestre'
                //'placeholder' => 'Choisir...'
            ))
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $trimesterForm->submit($request);
            if ($trimesterForm->isValid()) {
                $idTrimester = $trimesterForm->get('stdCombo')->getData();
                $currentYear = substr($idTrimester, 0, 4);
                $currentTrimester = substr($idTrimester, 4, 1);
            }
        } else {
            $lastResult = $resRepo->findLastMatch();
            $currentYear = $lastResult->getYear();
            $currentTrimester = $lastResult->getTrimester();
        }

        $results = $resRepo->listAllByTrimester($currentYear, $currentTrimester);

        $players = $plrRepo->findAllActives();
        $lastStandingId = $stdRepo->findLastStanding()->getId();
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

    public function standingsAction() {

        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
        $standings = $stdRepo->findAll();
        $lastStanding = $stdRepo->findLastStanding();
        $idStanding = $lastStanding->getId();
        $standingsName = array();
        $standingsId = array();
        foreach ($standings as $standing) {
            $standingsName[] = $standing->getName();
            $standingsId[] = $standing->getId();
        }
        $standingsName = array_combine($standingsId, $standingsName);
        $standingForm = $this->createFormBuilder()
            ->add('stdCombo', 'choice', array(
                'choices' => $standingsName,
                'label' => 'Choix'
                //'placeholder' => 'Choisir...'
            ))
            ->getForm();

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $standingForm->submit($request);
            if ($standingForm->isValid()) {
                $idStanding = $standingForm->get('stdCombo')->getData();
            }
        }
        
        $standing = $stdRepo->find($idStanding);
        //$rankings = $app['dao.ranking']->listAllByStanding($idStanding);

        return $this->render(
            'foot5x5MainBundle::standing.html.twig',
            array(
                'standing' => $standing,
                //'rankings' => $rankings,
                'standingForm' => $standingForm->createView()
            )
        );
    }

    public function playersAction() {
        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
        
        $players = $plrRepo->findAllActives();
        $lastStanding = $stdRepo->findLastStanding();

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

    public function notesAction() {

        $user = $this->getUser();
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $players = $plrRepo->findNotesFromUser($user);

        return $this->render(
            'foot5x5MainBundle::notes.html.twig',
            array(
                'user' => $user,
                'players' => $players
            )
        );
    }

    public function editNoteAction($id) {

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
        $noteForm = $this->createForm(new NoteType(), $note);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $noteForm->submit($request);
            if ($noteForm->isValid()) {
                /// MAJ des notes du joueur pour l'utilisateur connecté
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

    public function deleteNoteAction($id) {
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

    public function randomDrawAction() {
    
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $players = $plrRepo->findAllActives();
        $matchPlayers = array();
        $selectedPlayersList = array();

        $randomDrawForm= $this->createForm(new RandomDrawType(), $players);
        
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $randomDrawForm->submit($request);
            if ($randomDrawForm->isValid()) {
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

    public function financesAction() {

        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $trnRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Transaction');

        $debts = $plrRepo->findAllWithDebts();
        $credits = $plrRepo->findAllWithCredits();
        $totalDebts = $plrRepo->calcTotalDebts();
        $totalCredits = $plrRepo->calcTotalCredits();
        $transactions = $trnRepo->listLast(10);
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

    public function profileAction() {
        
        $user = $this->getUser();
        $player = $user->getPlayer();

        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');

        $lastStanding = $stdRepo->findLastStanding();
        $rank = $rnkRepo->findRankInStanding($lastStanding, $player);
        $currentForm = $mplRepo->getCurrentForm($player);
        $lastMatch = $mplRepo->getLastMatch($player);
        $resultForPlayer = $mplRepo->getResultForPlayer($lastMatch, $player);

        $bestRank = $rnkRepo->findBestRankEver($player);
        $worstRank = $rnkRepo->findWorstRankEver($player);
        $nbTitles = $rnkRepo->howManyTitlesForPlayer($player);
        $nbPodiums = $rnkRepo->howManyPodiumsForPlayer($player);
        $nbRelegations = $rnkRepo->howManyRelegationsForPlayer($player);
        $nbTimesLast = $rnkRepo->howManyTimesLastForPlayer($player);


        return $this->render(
            'foot5x5MainBundle::profile.html.twig',
            array(
                'user' => $user,
                'rank' => $rank,
                'currentForm' => $currentForm,
                'lastMatch' => $lastMatch,
                'resultForPlayer' => $resultForPlayer,
                'bestRank' => $bestRank,
                'worstRank' => $worstRank,
                'nbTitles' => $nbTitles,
                'nbPodiums' => $nbPodiums,
                'nbRelegations' => $nbRelegations,
                'nbTimesLast' => $nbTimesLast
            )
        );
    }

    public function editPwdAction() {
        $user = $this->getUser();

        // Création du formulaire associé
        $userPwdForm = $this->createForm(new UserPwdType(), $user);

        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $userPwdForm->submit($request);
            if ($userPwdForm->isValid()) {
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
}