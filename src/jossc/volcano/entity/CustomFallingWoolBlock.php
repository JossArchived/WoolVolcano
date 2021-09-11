<?php

namespace jossc\volcano\entity;

use pocketmine\block\Block;
use pocketmine\entity\object\FallingBlock;

class CustomFallingWoolBlock extends FallingBlock {

    protected function initEntity(): void
    {
        $this->block = Block::get(Block::WOOL, rand(0, 15));
        $this->setForceMovementUpdate(true);
        $this->setCanSaveWithChunk(false);
    }

    /**
     * @param int $tickDiff
     * @return bool
     */
    public function entityBaseTick(int $tickDiff = 1): bool
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