<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * MatchPlayerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatchPlayerRepository extends EntityRepository
{
	public function listAllForStanding(Community $community, $year, $trimester) {
        if ($trimester > 0) {
            // Trimestre
            $qb = $this->createQueryBuilder('mpl')
                ->Join('mpl.match', 'res')
                ->addSelect('res');
            $qb->where('res.community = :community')
                ->setParameter('community', $community)
                ->andWhere('res.year = :year')
                ->setParameter('year', $year)
                ->andWhere('res.trimester = :trim')
                ->setParameter('trim', $trimester)
                ->addOrderBy('mpl.player', 'ASC')
                ->addOrderBy('res.num', 'ASC');
        } else {
            // Année
            $qb = $this->createQueryBuilder('mpl')
                ->Join('mpl.match', 'res')
                ->addSelect('res');
            $qb->where('res.community = :community')
                ->setParameter('community', $community)
                ->andWhere('res.year = :year')
                ->setParameter('year', $year)
                ->addOrderBy('mpl.player', 'ASC')
                ->addOrderBy('res.trimester', 'ASC')
                ->addOrderBy('res.num', 'ASC');
        }
        return $qb->getQuery()->getResult();
    }

    public function randomDraw($selectedPlayers) {
        $i = 0;
        // Donner un ordre aléatoire aux éléments du tableau
        shuffle($selectedPlayers);
        foreach ($selectedPlayers as $player) {
            $matchPlayers[$i] = new MatchPlayer();
            $matchPlayers[$i]->setPlayer($player);
            if ($i<5) {
                $matchPlayers[$i]->setTeam('A');
            } else {
                $matchPlayers[$i]->setTeam('B');
            }
            $i++;
        }
        return $matchPlayers;
    }

    /**
     * Récupération de la forme sur les 5 derniers matchs pour un joueur
     */
    public function getCurrentForm($player) {
        $qb = $this->createQueryBuilder('mpl')
            ->Join('mpl.match', 'res')
            ->addSelect('res');
        $qb->where('mpl.player = :player')
            ->setParameter('player', $player)
            ->addOrderBy('res.date', 'DESC')
            ->setMaxResults(5);

        $lastResults = $qb->getQuery()->getResult();

        if (count($lastResults) > 0) {
            $currentForm = "";
            $firstResult = true;
            foreach ($lastResults as $lastResult) {
                $team = $lastResult->getTeam();
                $match = $lastResult->getMatch();
                $scoreTeamA = $match->getScoreTeamA();
                $scoreTeamB = $match->getScoreTeamB();

                // Gestion du séparateur à partir du 2e résultat affiché
                if ($firstResult) {
                    $firstResult = false;
                } else {
                    $currentForm = "-".$currentForm;
                }

                if ($scoreTeamA > $scoreTeamB) {
                    if ($team == "A") {
                        $currentForm = "V".$currentForm;
                    } else {
                        $currentForm = "D".$currentForm;
                    }
                } elseif ($scoreTeamA < $scoreTeamB) {
                    if ($team == "A") {
                        $currentForm = "D".$currentForm;
                    } else {
                        $currentForm = "V".$currentForm;
                    }
                } else {
                    $currentForm = "N".$currentForm;
                }
            }
        } else {
            $currentForm = "Aucun match joué";
        }
        return $currentForm;
    }

    /**
     * Récupération de la série en cours pour un joueur
     */
    public function getCurrentSerie($player) {
        $qb = $this->createQueryBuilder('mpl')
            ->Join('mpl.match', 'res')
            ->addSelect('res');
        $qb->where('mpl.player = :player')
            ->setParameter('player', $player)
            ->addOrderBy('res.date', 'DESC');
        $results = $qb->getQuery()->getResult();

        $currentSerie = "";
        $lastResult = "";
        $thisResult = "";
        $i = 0;

        foreach ($results as $result) {
            $i++;

            $team = $result->getTeam();
            $match = $result->getMatch();
            $scoreTeamA = $match->getScoreTeamA();
            $scoreTeamB = $match->getScoreTeamB();

            if ($scoreTeamA > $scoreTeamB) {
                if ($team == "A") {
                    $thisResult = "V";
                } else {
                    $thisResult = "D";
                }
            } elseif ($scoreTeamA < $scoreTeamB) {
                if ($team == "A") {
                    $thisResult = "D";
                } else {
                    $thisResult = "V";
                }
            } else {
                $thisResult = "N";
            }

            if($lastResult != $thisResult && $i > 1) {
                $i--;
                break;
            }
            $lastResult = $thisResult;
        }

        if ($i >= 5) {
            $currentSerie = $i.$lastResult;
        } else {
            $currentSerie = "";
        }
        return $currentSerie;
    }

    /**
     * Récupération du dernier match d'un joueur
     */
    public function getLastMatch($player) {
        $qb = $this->createQueryBuilder('mpl')
            ->Join('mpl.match', 'res')
            ->addSelect('res');
        $qb->where('mpl.player = :player')
            ->setParameter('player', $player)
            ->addOrderBy('res.date', 'DESC')
            ->setMaxResults(1);

        try {
            $lastMatch = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return NULL;
        }
        return $lastMatch->getMatch();
    }

    /**
     * Récupération du résultat d'un match pour un joueur
     */
    public function getResultForPlayer($match, $player) {
        $qb = $this->createQueryBuilder('mpl')
            ->Join('mpl.match', 'res')
            ->addSelect('res');
        $qb->where('mpl.player = :player')
            ->andWhere('mpl.match = :match')
            ->setParameter('player', $player)
            ->setParameter('match', $match);

        try {
            $result = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return "";
        }

        $team = $result->getTeam();
        $match = $result->getMatch();
        $scoreTeamA = $match->getScoreTeamA();
        $scoreTeamB = $match->getScoreTeamB();

        $resultForPlayer = "(";
        if ($scoreTeamA > $scoreTeamB) {
            if ($team == "A") {
                $resultForPlayer .= $scoreTeamA."-".$scoreTeamB;
            } else {
                $resultForPlayer .= $scoreTeamB."-".$scoreTeamA;
            }
        } elseif ($scoreTeamA < $scoreTeamB) {
            if ($team == "A") {
                $resultForPlayer .= $scoreTeamA."-".$scoreTeamB;
            } else {
                $resultForPlayer .= $scoreTeamB."-".$scoreTeamA;
            }
        } else {
            $resultForPlayer .= $scoreTeamA."-".$scoreTeamB;
        }
        $resultForPlayer .= ")";
        
        return $resultForPlayer;
    }

    /**
     * Récupération du bilan global des résultats d'un joueur
     */
    public function getAllResultsForPlayer($player) {
        $qb = $this->createQueryBuilder('mpl')
            ->Join('mpl.match', 'res')
            ->addSelect('res');
        $qb->where('mpl.player = :player')
            ->setParameter('player', $player);

        try {
            $results = $qb->getQuery()->getResult();
        } catch (NoResultException $e) {
            return "Aucun match joué";
        }

        $globalResults = "";
        $totalW = 0;
        $totalD = 0;
        $totalL = 0;
        $firstResult = true;
        foreach ($results as $result) {
            $team = $result->getTeam();
            $match = $result->getMatch();
            $scoreTeamA = $match->getScoreTeamA();
            $scoreTeamB = $match->getScoreTeamB();

            if ($scoreTeamA > $scoreTeamB) {
                if ($team == "A") {
                    $totalW += 1;
                } else {
                    $totalL += 1;
                }
            } elseif ($scoreTeamA < $scoreTeamB) {
                if ($team == "A") {
                    $totalL += 1;
                } else {
                    $totalW += 1;
                }
            } else {
                $totalD += 1;
            }
        }
        $globalResults = $totalW."V ".$totalD."N ".$totalL."D";
        return $globalResults;
    }
}
