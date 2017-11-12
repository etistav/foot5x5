<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * StandingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StandingRepository extends EntityRepository
{
	public function find($id) {
    	$qb = $this->createQueryBuilder('std')
    		->leftJoin('std.rankings', 'rnk')
    		->addSelect('rnk');
    	$qb->where('std.id = :id')
    		->setParameter('id', $id)
    		->addOrderBy('rnk.rank', 'ASC');

    	return $qb->getQuery()->getSingleResult();
    }

    public function findByCommunity($communityId)
    {
		$qb = $this->createQueryBuilder('std')
			->leftJoin('std.rankings', 'rnk')
			->addSelect('rnk')
			->where('std.community = :cmnId')
			->setParameter('cmnId', $communityId)
			->addOrderBy('std.year', 'DESC')
			->addOrderBy('std.trimester', 'DESC')
			->addOrderBy('rnk.rank', 'ASC');
		
		$standings = $qb->getQuery()->getResult();
        return $standings;
    }

    public function findLastStanding($communityId) {
		$qb = $this->createQueryBuilder('std')
			->where('std.community = :cmnId')
			->setParameter('cmnId', $communityId)
			->addOrderBy('std.year', 'DESC')
			->addOrderBy('std.trimester', 'DESC')
			->setMaxResults(1);
		try {
			$lastStanding = $qb->getQuery()->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
		return $lastStanding;
    }

    public function findByTrimester($year, $trimester) {
        $hasToBeCreated = false;
        $qb = $this->createQueryBuilder('std');
        $qb->where('std.year = :year')
            ->setParameter('year', $year)
            ->andWhere('std.trimester = :trim')
            ->setParameter('trim', $trimester)
            ->setMaxResults(1);
        try {
            $standing = $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $hasToBeCreated = true;
        }
        return $hasToBeCreated;
    }

    public function initializeStanding($year, $trimester) {
        // Vérification de l'existence du classement annuel
        $hasToBeCreated = $this->findByTrimester($year, 0);
        if ($hasToBeCreated) {
            // Initialisation d'un nouveau classement
            $standing = New Standing();
            $standing->setYear($year);
            $standing->setTrimester(0);

            // Ecriture du classement en BDD
            $em = $this->_em;
            $em->persist($standing);
            $em->flush();
        }
        // Vérification de l'existence du classement trimestriel
        $hasToBeCreated = $this->findByTrimester($year, $trimester);
        if ($hasToBeCreated) {
            // Initialisation d'un nouveau classement
            $standing = New Standing();
            $standing->setYear($year);
            $standing->setTrimester($trimester);

            // Ecriture du classement en BDD
            $em = $this->_em;
            $em->persist($standing);
            $em->flush();
        }
        return $hasToBeCreated;
    }
}
