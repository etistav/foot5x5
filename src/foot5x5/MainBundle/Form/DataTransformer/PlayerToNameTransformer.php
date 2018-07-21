<?php
// src/foot5x5/MainBundle/Form/DataTransformer/PlayerToNameTransformer.php

namespace foot5x5\MainBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use foot5x5\MainBundle\Entity\Player;

class PlayerToNameTransformer implements DataTransformerInterface
{
    private $repo;

    public function __construct($repo)
    {
        $this->repo = $repo;
    }

    /**
     * Transforms an object Player to a string (name).
     *
     * @param  Player|null $player
     * @return string
     */
    public function transform($player)
    {
        if (null === $player) {
            return null;
        }
        $playerName = $player->getName();

        return $playerName;
    }

    /**
     * Transforms a string (playerId) to an object Player.
     *
     * @param  string $playerId
     * @return Player|null
     * @throws TransformationFailedException if object Player is not found.
     */
    public function reverseTransform($playerId)
    {
        if (!$playerId) {
            return null;
        }

        $player = $this->repo->findOneBy(array('id' => $playerId));

        if (null === $player) {
            throw new TransformationFailedException(sprintf(
                'Il n\'existe pas de joueur avec l\ID "%s"!',
                $playerId
            ));
        }

        return $player;
    }
}
