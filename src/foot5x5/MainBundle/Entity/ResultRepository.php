<?php

namespace foot5x5\MainBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Validator\Constraints\Null;

/**
 * ResultRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResultRepository extends EntityRepository
{
	/**
	 * Retrieve the last match of a community
	 * 
	 * @param int $communityId
	 * @return Result lastMatch
	 */
	public function findLastMatch($communityId)
	{
		$qb = $this->createQueryBuilder('res');
		$qb->where('res.community = :cmnId')
			->setParameter('cmnId', $communityId)
			->addOrderBy('res.year', 'DESC')
			->addOrderBy('res.trimester', 'DESC')
			->addOrderBy('res.num', 'DESC')
			->setMaxResults(1);
		try {
			$lastMatch = $qb->getQuery()->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
		return $lastMatch;
    }

    /**
     * Retrieve all results of a community for one given quarter
     * 
     * @param int $communityId
     * @param int $year
     * @param int $trimester
     * @return array
     */
	public function findByTrimester($communityId, $year, $trimester)
	{
		$qb = $this->createQueryBuilder('res');
		$qb->where('res.year = :year')
			->setParameter('year', $year)
			->andWhere('res.trimester = :trim')
			->setParameter('trim', $trimester)
			->andWhere('res.community = :cmnId')
			->setParameter('cmdId', $communityId)
			->orderBy('res.num', 'DESC');
		
		return $qb->getQuery()->getResult();
    }

    /**
     * Retrieve all results of a community for one given year
     * 
     * @param int $communityId
     * @param int $year
     * @return array
     */
	public function findByYear($communityId, $year)
	{
		$qb = $this->createQueryBuilder('res');
		$qb->where('res.year = :year')
			->setParameter('year', $year)
			->andWhere('res.community = :cmnId')
			->setParameter('cmdId', $communityId)
			->addOrderBy('res.trimester', 'DESC')
			->addOrderBy('res.num', 'DESC');
		
		return $qb->getQuery()->getResult();
    }

    /**
     * Retrieve all results and match players of a community for one given quarter
     *  
     * @param int $communityId
     * @param int $year
     * @param int $trimester
     * @return array
     */
	public function listAllByTrimester($communityId, $year, $trimester)
	{
		$qb = $this->createQueryBuilder('res')
			->Join('res.matchPlayers', 'mpl')
			->addSelect('mpl');
		$qb->where('res.year = :year')
			->setParameter('year', $year)
			->andWhere('res.trimester = :trim')
			->setParameter('trim', $trimester)
			->andWhere('res.community = :cmnId')
			->setParameter('cmnId', $communityId)
			->orderBy('res.num', 'DESC');
		
		return $qb->getQuery()->getResult();
    }

    /**
     * Retrieve all quarters with match played for a given community
     * 
     * @param int $communityId
     * @return array
     */
    public function listAllTrimesters($communityId)
    {
		$qb = $this->createQueryBuilder('res')
			->select('res.year, res.trimester')
			->distinct()
			->where('res.community = :cmnId')
			->setParameter('cmnId', $communityId)
			->addOrderBy('res.year', 'DESC')
			->addOrderBy('res.trimester', 'DESC');

        return $qb->getQuery()->getResult();
    }

	public function findFollowingGames(Result $match)
	{
		$year = $match->getYear();
		$trimester = $match->getTrimester();
		$date = $match->getDate();
		$communityId = $match->getCommunity()->getId();
		
		$qb = $this->createQueryBuilder('res');
		$qb->where('res.year = :year')
			->andWhere('res.trimester = :trim')
			->andWhere('res.date > :date')
			->andWhere('res.community = :cmnId')
			->setParameter('year', $year)
			->setParameter('trim', $trimester)
			->setParameter('date', $date)
			->setParameter('cmnId', $communityId)
			->orderBy('res.num', 'DESC');
		
		return $qb->getQuery()->getResult();
	}

	/**
	 * Determine the match number of a new created match
	 * 
	 * @param Result $match
	 * @return number
	 */
    public function determineMatchNumber(Result $match) {

        $year = $match->getYear();
        $trimester = $match->getTrimester();
        $communityId = $match->getCommunity()->getId();

        $allResults = $this->findByTrimester($communityId, $year, $trimester);
        $followingGames = $this->findFollowingGames($match);
        $nbAllResults = count($allResults);
        $nbFollowingGames = count($followingGames);

        if ($nbAllResults > 0) {
            if ($nbFollowingGames > 0) {
                foreach ($followingGames as $game) {
                    $num = $game->getNum();
                    $this->updateMatchNumber($game->getId(), $num + 1);
                }
            } else {
                $num = $nbAllResults + 1;
            }
        } else {
            $num = 1;
        }
        return $num;
    }

    /**
     * Update match number of all following matches
     * after the removal of one match
     * 
     * @param Result $match
     */
	public function updateMatchNumbersAfterRemoval(Result $match)
	{
		$followingGames = $this->findFollowingGames($match);
		$nbFollowingGames = count($followingGames);
		
		if ($nbFollowingGames > 0)
		{
			foreach ($followingGames as $game)
			{
				$num = $game->getNum();
				$this->updateMatchNumber($game->getId(), $num - 1);
			}
		}
	}

	/**
	 * Update the number of a match
	 * 
	 * @param int $id
	 * @param int $num
	 */
	public function updateMatchNumber($id, $num)
	{
		$qb = $this->getEntityManager()->createQueryBuilder()
			->update('foot5x5MainBundle:Result', 'res')
			->set('res.num', '?1')
			->where('res.id = ?2')
			->setParameter(1, $num)
			->setParameter(2, $id)
			->getQuery();
		$qb->execute();
	}
}
