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
	/**
	 * Retrieve a standing with corresponding rankings
	 * 
	 * @param int $id Standing Id
	 */
	public function findStanding($id)
	{
		$qb = $this->createQueryBuilder('std')
			->leftJoin('std.rankings', 'rnk')
			->addSelect('rnk');
		$qb->where('std.id = :id')
			->setParameter('id', $id)
			->addOrderBy('rnk.rank', 'ASC');
		
		return $qb->getQuery()->getSingleResult();
	}
	
	/**
	 * Retrieve all standings for a given community
	 * 
	 * @param int $communityId
	 * @return array
	 */
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

	/**
	 * Retrieve the last standing of a given community
	 * 
	 * @param int $communityId
	 * @return Standing
	 */
	public function findLastStanding($communityId)
	{
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

	/**
	 * Returns true if the standing has to be created
	 * 
	 * @param int $year
	 * @param int $trimester
	 * @return boolean
	 */
	public function findByTrimester(Community $community, $year, $trimester)
	{
		$hasToBeCreated = false;
		$qb = $this->createQueryBuilder('std');
		$qb->where('std.community = :cmnId')
			->setParameter('cmnId', $community)
			->andWhere('std.year = :year')
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

	/**
	 * Initialize the standings if necessary
	 * 
	 * @param Community $community
	 * @param int $year
	 * @param int $trimester
	 * @return boolean
	 */
	public function initializeStanding($community, $year, $trimester)
	{
		// Check if the annual standing has to be created
		$hasToBeCreated = $this->findByTrimester($community, $year, 0);
		if ($hasToBeCreated)
		{
			// Initialize a new annual standing
			$standing = New Standing();
			$standing->setYear($year);
			$standing->setTrimester(0);
			$standing->setCommunity($community);
			
			// Persist it into the DB
			$em = $this->_em;
			$em->persist($standing);
			$em->flush();
		}
		
		// Check if the quarterly standing has to be created
		$hasToBeCreated = $this->findByTrimester($community, $year, $trimester);
		if ($hasToBeCreated)
		{
			// Initialize a new quarterly standing
			$standing = New Standing();
			$standing->setYear($year);
			$standing->setTrimester($trimester);
			$standing->setCommunity($community);
			
			// Persist it into the DB
			$em = $this->_em;
			$em->persist($standing);
			$em->flush();
		}
		return $hasToBeCreated;
	}
}
