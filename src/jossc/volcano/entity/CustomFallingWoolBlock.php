<?php

namespace jossc\volcano\entity;

use pocketmine\entity\object\FallingBlock;
use pocketmine\nbt\tag\CompoundTag;

class CustomFallingWoolBlock extends FallingBlock {

    /*** @param CompoundTag $nbt */
    protected function initEntity(CompoundTag $nbt): void
    {
        parent::initEntity($nbt);

        $this->setForceMovementUpdate(true);
        $this->setSilent(true);
        $this->setCanSaveWithChunk(false);
    }

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