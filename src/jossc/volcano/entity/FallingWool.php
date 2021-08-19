<?php

namespace jossc\volcano\entity;

use pocketmine\entity\object\FallingBlock;

class FallingWool extends FallingBlock {

    /**
     * @param int $tickDiff
     * @return bool
     */
    protected function entityBaseTick(int $tickDiff = 1): bool
    {
        if ($this->isClosed()) {
            return false;
        }

        if (!$this->isFlaggedForDespawn()) {
            if ($this->onGround) {
                $this->flagForDespawn();
            }
        }

        return true;
    }
}