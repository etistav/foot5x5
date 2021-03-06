<?php

namespace foot5x5\MainBundle\Entity;

use foot5x5\UserBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * NoteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NoteRepository extends EntityRepository
{
    // not used anymore...
    public function findFromUser(User $user) {
        $qb = $this->createQueryBuilder('notes')
            ->leftJoin('notes.player', 'plr')
            ->addSelect('plr');
        $qb->where('notes.evaluator = :user')
            ->setParameter('user', $user)
            ->addOrderBy('plr.name', 'ASC');
        return $qb->getQuery()->getResult();
    }

    public function findNoteFromUser(User $user, Player $player) {
        $qb = $this->createQueryBuilder('notes')
            ->leftJoin('notes.player', 'plr')
            ->addSelect('plr');
        $qb->where('notes.evaluator = :user')
            ->andWhere('notes.player = :player')
            ->setParameter('user', $user)
            ->setParameter('player', $player);

        try {
            $note = $qb->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            $note = null;
        }
        return $note;
    }

    public function updateNotesPlayer(Player $player) {
        
        $qb = $this->createQueryBuilder('notes')
            ->leftJoin('notes.player', 'plr');
        $qb->where('notes.player = :player')
            ->setParameter('player', $player);
        $notesPlayer = $qb->getQuery()->getResult();
        $nbEval = count($notesPlayer);

        if ($nbEval > 0) {
            $sumValAtt = 0;
            $sumValDef = 0;
            $sumValPhy = 0;
            $sumValAvg = 0;
            foreach ($notesPlayer as $note) {
                $sumValAtt += $note->getValAtt();
                $sumValDef += $note->getValDef();
                $sumValPhy += $note->getValPhy();
                $sumValAvg += $note->getValAvg();
            }
            $valAtt = $sumValAtt/$nbEval;
            $valDef = $sumValDef/$nbEval;
            $valPhy = $sumValPhy/$nbEval;
            $valAvg = $sumValAvg/$nbEval;
        } else {
            $valAtt = 5;
            $valDef = 5;
            $valPhy = 5;
            $valAvg = 5;
        }
        $player->setValAtt($valAtt);
        $player->setValDef($valDef);
        $player->setValPhy($valPhy);
        $player->setValAvg($valAvg);
        return $player;
    }
}
