<?php

namespace foot5x5\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use foot5x5\MainBundle\Entity\MatchPlayer;
use foot5x5\MainBundle\Entity\Player;
use foot5x5\MainBundle\Entity\Ranking;
use foot5x5\MainBundle\Entity\Result;
use foot5x5\MainBundle\Entity\Transaction;
use foot5x5\UserBundle\Entity\User;

use foot5x5\MainBundle\Form\PlayerType;
use foot5x5\MainBundle\Form\ResultType;
use foot5x5\MainBundle\Form\TransactionType;
use foot5x5\UserBundle\Form\UserEditType;
use foot5x5\UserBundle\Form\UserType;

class AdminController extends Controller
{
    /**
     * Management of the admin home page
     * 
     * @param Request $request
     */
    public function indexAction(Request $request) {

        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
        $trnRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Transaction');
        $usrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5UserBundle:User');

        // Gestion de l'onglet actif en session et réinitialisation
        $session = $request->getSession();
        if ($session->get('activeTab') == '') {
            $activeTab = 'results';
        } else {
            $activeTab = $session->get('activeTab');
        }
        $session->set('activeTab', '');

        // Récupération de tous les joueurs, classements et utilisateurs
        $players = $plrRepo->findAll();
        $standings = $stdRepo->findAll();
        $users = $usrRepo->findAll();
        $trimesters = $resRepo->listAllTrimesters();

        // Alimentation de la combobox trimestre
        $trimNames = array();
        $trimIds = array();
        foreach ($trimesters as $trimester) {
            if ($trimester['trimester'] == 0) {
                $trimName = $trimester['year'].' annuel';
            } else {
                $trimName = 'T0'.$trimester['trimester'].' - '.$trimester['year'];
            }
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
        $transactions = $trnRepo->listAllByTrimester($currentYear, $currentTrimester);

        return $this->render(
			'foot5x5MainBundle::admin.html.twig',
			array(
                'activeTab' => $activeTab,
				'standings' => $standings,
                'results' => $results,
                'players' => $players,
                'users' => $users,
                'transactions' => $transactions,
                'trimesterForm' => $trimesterForm->createView(),
                'currentYear' => $currentYear,
                'currentTrimester' => $currentTrimester
			)
		);
    }

    /***********************************
     *         ADMIN - MATCHES         *
     ***********************************/

    /**
     * Management of the 'add match' view
     * 
     * @param Request $request
     */
    public function addMatchAction(Request $request) {
        $match = new Result();

        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        // $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');

        $players = $plrRepo->findAll();
        $matchPlayerA = array();
        $matchPlayerB = array();
        
        
        // Initialisation de 5 joueurs dans chaque équipe
        for ($i = 1; $i <= 5; $i++) {
            $matchPlayerA[$i] = new MatchPlayer();
            // $playerA = $plrRepo->find(2 * $i - 1);
            // $matchPlayerA[$i]->setPlayer($playerA);
            $matchPlayerA[$i]->setTeam('A');
            $match->addMatchPlayer($matchPlayerA[$i]);

            $matchPlayerB[$i] = new MatchPlayer();
            // $playerB = $plrRepo->find(2 * $i);
            // $matchPlayerB[$i]->setPlayer($playerB);
            $matchPlayerB[$i]->setTeam('B');
            $match->addMatchPlayer($matchPlayerB[$i]);
        }

        // Création du formulaire associé
        $matchForm = $this->createForm(new ResultType(), $match);

        if ($request->getMethod() == 'POST') {
            $matchForm->submit($request);
            if ($matchForm->isValid()) {

                //echo $request->getMethod();
                // Détermination du n° de match
                $matchNum = $resRepo->findMatchNumber($match);
                $match->setNum($matchNum);

                // Création d'un classement pour le trimestre si besoin
                // $isStandingCreated = $stdRepo->initializeStanding($match->getYear(), $match->getTrimester());

                // Ecriture du match en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($match);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'Le match n°'.$matchNum.' a bien été créé.');
                $this->get('session')->set('activeTab', 'results');
                return $this->redirect($this->generateUrl('admin_home'));
            }
            else {
                echo $match->getNum();
                echo $request->getMethod();
                var_dump($_POST);
            }
        }
        return $this->render(
            'foot5x5MainBundle::match_form.html.twig',
            array(
                'title' => 'Nouveau match',
                'buttonLabel' => 'Créer',
                'players' => $players,
                'match' => $match,
                'matchForm' => $matchForm->createView()
            )
        );
    }

    /**
     * Management of the 'edit match' view
     *
     * @param Request $request
     * @param integer $id match id
     */
    public function editMatchAction(Request $request, $id) {

        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');

        $players = $plrRepo->findAll();
        $match = $resRepo->find($id);
        $dateEditedMatch = $match->getDate()->format('d/m/Y');
        $matchForm = $this->createForm(new ResultType(), $match);


        if ($request->getMethod() == 'POST') {
            $matchForm->submit($request);
            if ($matchForm->isValid()) {

                // Si date modifiée, mise à jour des n° de matchs suivants
                // TODO gestion n°match si modif date

                // MAJ du match en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($match);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'Le match du '.$dateEditedMatch.' a bien été modifié.');
                $this->get('session')->set('activeTab', 'results');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::match_form.html.twig',
            array(
                'title' => 'Modifier match',
                'buttonLabel' => 'Enregistrer',
                'players' => $players,
                'match' => $match,
                'matchForm' => $matchForm->createView()
            )
        );
    }

    /**
     * Handle the removal of a match
     *
     * @param integer $id match id
     */
    public function deleteMatchAction($id) {

        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        $match = $resRepo->find($id);
        $dateDeletedMatch = $match->getDate()->format('d/m/Y');

        // Mise à jour des numéros de match du trimestre correspondant
        $resRepo->updateMatchNumbers($match);

        // Suppression du match en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($match);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'Le match du '.$dateDeletedMatch.' a bien été supprimé.');
        $this->get('session')->set('activeTab', 'results');
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /***********************************
     *        ADMIN - STANDINGS        *
     ***********************************/

    /**
     * Handle the calculation of a standing
     *
     * @param integer $id Standing id
     */
    public function calcStandingAction($id) {

        $stdRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Standing');
        $mplRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:MatchPlayer');
        $resRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Result');
        $rnkRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Ranking');
        $em = $this->getDoctrine()->getManager();

        // Détermination du classement correspondant
        $standing = $stdRepo->find($id);
        $trimester = $standing->getTrimester();
        $year = $standing->getYear();
        $standingName = $standing->getName();

        // Suppression de tous les rankings correspondant à ce classement
        $rnkRepo->clearStanding($standing);

        
        if ($trimester == 0) {
            // Récupération du nombre total de matchs effectués sur l'année
            $results = $resRepo->findByYear($year);
        } else {
            // Récupération du nombre total de matchs effectués sur ce trimestre
            $results = $resRepo->findByTrimester($year, $trimester);
        }
        $nbTotalResults = count($results);
        $minParticipation = 0.33;

        $currentPlayerId = 0;
        $matchPlayers = $mplRepo->listAllForStanding($year, $trimester);
        foreach ($matchPlayers as $matchPlayer) {
            $playerId = $matchPlayer->getPlayer()->getId();
            if ($currentPlayerId <> $playerId) {
                if (isset($ranking)) {
                    $participation = $ranking->getPlayed()/$nbTotalResults;
                    if ($participation >= $minParticipation) {
                        // Insertion du ranking en BDD
                        $ranking->setGoalsDiff($ranking->getGoalsFor() - $ranking->getGoalsAgainst());
                        $ranking->calcEval($nbTotalResults);
                        $em->persist($ranking);
                        $em->flush();
                    }
                }
                $currentPlayerId = $playerId;
                $player = $matchPlayer->getPlayer();
                $ranking = new Ranking();
                $ranking->setStanding($standing);
                $ranking->setPlayer($player);
            }
            $match = $matchPlayer->getMatch();
            $team = $matchPlayer->getTeam();
            $ranking->statsMatch($match, $team);   
        }
        // Prise en compte de la dernière occurence
        if (isset($ranking)) {
            $participation = $ranking->getPlayed()/$nbTotalResults;
            if ($participation >= $minParticipation) {
                // Insertion du ranking en BDD
                $ranking->setGoalsDiff($ranking->getGoalsFor() - $ranking->getGoalsAgainst());
                $ranking->calcEval($nbTotalResults);
                $em->persist($ranking);
                $em->flush();
            }
        }

        // Gestion des rangs du classement
        $rankings = $rnkRepo->findByStanding($standing);
        $nbPlayers = count($rankings);
        $rank = 0;
        foreach ($rankings as $ranking) {
            $rank++;
            $ranking->setRank($rank);
            // Mise à jour du rang en BDD
            $em->persist($ranking);
            $em->flush();
        }

        // Sauvegarde en BDD du nb de match total et du nb de joueurs classés
        $standing->setNbMatch($nbTotalResults);
        $standing->setNbPlayers($nbPlayers);
        $em->persist($standing);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'Le classement '.$standingName.' a bien été calculé.');
        $this->get('session')->set('activeTab', 'standings');
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /***********************************
     *         ADMIN - PLAYERS         *
     ***********************************/

    /**
     * Management of the 'add player' view
     * 
     * @param Request $request
     */
    public function addPlayerAction(Request $request) {
        $player = new Player();

        // Création du formulaire associé
        $playerForm = $this->createForm(new PlayerType(), $player);

        if ($request->getMethod() == 'POST') {
            $playerForm->submit($request);
            if ($playerForm->isValid()) {
                // Ecriture du player en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'Le joueur '.$player->getName().' a bien été créé.');
                $this->get('session')->set('activeTab', 'players');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::player_form.html.twig',
            array(
                'title' => 'Nouveau Joueur',
                'buttonLabel' => 'Créer',
                'player' => $player,
                'playerForm' => $playerForm->createView()
            )
        );
    }

    /**
     * Management of the 'edit match' view
     *
     * @param Request $request
     * @param integer $id Player id
     */
    public function editPlayerAction(Request $request, $id) {
        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $player = $plrRepo->find($id);

        // Création du formulaire associé
        $playerForm = $this->createForm(new PlayerType(), $player);

        if ($request->getMethod() == 'POST') {
            $playerForm->submit($request);
            if ($playerForm->isValid()) {
                // Ecriture du player en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($player);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'Le joueur '.$player->getName().' a bien été modifié.');
                $this->get('session')->set('activeTab', 'players');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::player_form.html.twig',
            array(
                'title' => 'Modification Joueur',
                'buttonLabel' => 'Enregistrer',
                'player' => $player,
                'playerForm' => $playerForm->createView()
            )
        );
    }

    /**
     * Handle the removal of a player
     *
     * @param integer $id Player id
     */
    public function deletePlayerAction($id) {

        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $player = $plrRepo->find($id);
        $playerName = $player->getName();

        // Attention! Le joueur ne peut être supprimé s'il a joué au moins un match
        // TODO... Ajout notion "inactivité" joueur

        // Suppression du joueur en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($player);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'Le joueur '.$playerName.' a bien été supprimé.');
        $this->get('session')->set('activeTab', 'players');
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /**
     * Contrôller to handle the update of one player's balance
     *
     * @param integer $id Player id
     * @param string $operation 'credit' or 'debit'
     */
    public function updatePlayerBalanceAction($id, $operation) {

        $plrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Player');
        $prmRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Param');
        $player = $plrRepo->find($id);
        $playerName = $player->getName();
        $playerBalance = $player->getCashBalance();
        $matchPrice = $prmRepo->findOneBy(array('name' => 'tarif'))->getValue();

        $this->get('session')->set('activeTab', 'players');

        if ($operation == 'credit') {
            $playerBalanceNew = $playerBalance + $matchPrice;
        } elseif ($operation == 'debit') {
            $playerBalanceNew = $playerBalance - $matchPrice;
        } else {
            $this->get('session')->getFlashBag()->add('success', 'Le solde du joueur '.$playerName.' n\'a pas pu être modifié.');
            return $this->redirect($this->generateUrl('admin_home'));
        }

        $em = $this->getDoctrine()->getManager();
        $player->setCashBalance($playerBalanceNew);
        $em->persist($player);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'Le solde de '.$playerName.' est bien passé de '.$playerBalance.'€ à '.$playerBalanceNew.'€.');
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /***********************************
     *          ADMIN - USERS          *
     ***********************************/

    /**
     * Management of the 'add user' view
     * 
     * @param Request $request
     */
    public function addUserAction(Request $request) {
        $user = new User();

        // Création du formulaire associé
        $userForm = $this->createForm(new UserType(), $user);

        if ($request->getMethod() == 'POST') {
            $userForm->submit($request);
            if ($userForm->isValid()) {
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
                $this->get('session')->getFlashBag()->add('success', 'Le user '.$user->getUsername().' a bien été créé.');
                $this->get('session')->set('activeTab', 'users');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::user_form.html.twig',
            array(
                'action' => 'addUser',
                'title' => 'Nouvel Utilisateur',
                'buttonLabel' => 'Créer',
                'user' => $user,
                'userForm' => $userForm->createView()
            )
        );
    }

    /**
     * Management of the 'edit user' view
     *
     * @param Request $request
     * @param integer $id User id
     */
    public function editUserAction(Request $request, $id) {
        $usrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5UserBundle:User');
        $user = $usrRepo->find($id);

        // Création du formulaire associé
        $userForm = $this->createForm(new UserEditType(), $user);

        if ($request->getMethod() == 'POST') {
            $userForm->submit($request);
            if ($userForm->isValid()) {

                // Ecriture du user en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'Le user '.$user->getUsername().' a bien été modifié.');
                $this->get('session')->set('activeTab', 'users');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::user_form.html.twig',
            array(
                'action' => 'editUser',
                'title' => 'Modification utilisateur',
                'buttonLabel' => 'Enregistrer',
                'user' => $user,
                'userForm' => $userForm->createView()
            )
        );
    }

    /**
     * Handle the removal of a user
     *
     * @param integer $id User id
     */
    public function deleteUserAction($id) {

        $usrRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5UserBundle:User');
        $user = $usrRepo->find($id);
        $username = $user->getUsername();

        // Suppression du user en BDD
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'L\'utilisateur '.$username.' a bien été supprimé.');
        $this->get('session')->set('activeTab', 'users');
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /***********************************
     *         ADMIN - FINANCES        *
     ***********************************/

    /**
     * Management of the 'add transaction' view
     * 
     * @param Request $request
     */
    public function addTransactionAction(Request $request) {
        $transaction = new Transaction();

        // Création du formulaire associé
        $trnForm = $this->createForm(new TransactionType(), $transaction);

        if ($request->getMethod() == 'POST') {
            $trnForm->submit($request);
            if ($trnForm->isValid()) {
                // Ecriture du user en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($transaction);
                $em->flush();

                // Attention! La création d'une transaction doit impacter le cashBalance des joueurs concernés
                $previousAmount = 0;
                $amount = $transaction->getAmount();
                $giver = $transaction->getGiver();
                $giver->handleTransaction($amount, $previousAmount, false);
                $em->persist($giver);
                $em->flush();
                $receiver = $transaction->getReceiver();
                $receiver->handleTransaction($amount, $previousAmount, true);
                $em->persist($receiver);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'La transaction de '.$amount.'€ entre '.$giver->getName().' et '.$receiver->getName().' a bien été créée.');
                $this->get('session')->set('activeTab', 'finance');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::transaction_form.html.twig',
            array(
                'title' => 'Nouvelle Transaction',
                'buttonLabel' => 'Créer',
                'transaction' => $transaction,
                'trnForm' => $trnForm->createView()
            )
        );
    }

    /**
     * Management of the 'edit transaction' view
     *
     * @param Request $request
     * @param integer $id Transaction id
     */
    public function editTransactionAction(Request $request, $id) {
        $trnRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Transaction');
        $transaction = $trnRepo->find($id);
        $previousAmount = $transaction->getAmount();

        // Création du formulaire associé
        $trnForm = $this->createForm(new TransactionType(), $transaction);

        if ($request->getMethod() == 'POST') {
            $trnForm->submit($request);
            if ($trnForm->isValid()) {
                // Modification de la transaction en BDD
                $em = $this->getDoctrine()->getManager();
                $em->persist($transaction);
                $em->flush();

                // Attention! La modif d'une transaction doit impacter le cashBalance des joueurs concernés
                $amount = $transaction->getAmount();
                $giver = $transaction->getGiver();
                $giver->handleTransaction($amount, $previousAmount, false);
                $em->persist($giver);
                $em->flush();
                $receiver = $transaction->getReceiver();
                $receiver->handleTransaction($amount, $previousAmount, true);
                $em->persist($receiver);
                $em->flush();

                // Redirection sur la page d'admin avec gestion du message d'info
                $this->get('session')->getFlashBag()->add('success', 'La transaction de '.$amount.'€ entre '.$giver->getName().' et '.$receiver->getName().' a bien été modifiée.');
                $this->get('session')->set('activeTab', 'finance');
                return $this->redirect($this->generateUrl('admin_home'));
            }
        }
        return $this->render(
            'foot5x5MainBundle::transaction_form.html.twig',
            array(
                'title' => 'Modification Transaction',
                'buttonLabel' => 'Enregistrer',
                'transaction' => $transaction,
                'trnForm' => $trnForm->createView()
            )
        );
    }

    /**
     * Handle the removal of a transaction
     *
     * @param integer $id Transaction id
     */
    public function deleteTransactionAction($id) {
        $trnRepo = $this->getDoctrine()->getManager()->getRepository('foot5x5MainBundle:Transaction');
        $transaction = $trnRepo->find($id);

        $em = $this->getDoctrine()->getManager();

        // Attention! La suppression d'une transaction doit impacter le cashBalance des joueurs concernés
        $previousAmount = $transaction->getAmount();
        $amount = 0;
        $giver = $transaction->getGiver();
        $giver->handleTransaction($amount, $previousAmount, false);
        $em->persist($giver);
        $em->flush();
        $receiver = $transaction->getReceiver();
        $receiver->handleTransaction($amount, $previousAmount, true);
        $em->persist($receiver);
        $em->flush(); 

        // Suppression de la transaction en BDD
        $em->remove($transaction);
        $em->flush();

        // Redirection sur la page d'admin avec gestion du message d'info
        $this->get('session')->getFlashBag()->add('success', 'La transaction de '.$amount.'€ entre '.$giver->getName().' et '.$receiver->getName().' a bien été supprimée.');
        $this->get('session')->set('activeTab', 'finance');
        return $this->redirect($this->generateUrl('admin_home'));
    }
}
