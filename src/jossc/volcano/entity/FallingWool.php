<?php

namespace jossc\volcano\entity;

use pocketmine\entity\object\FallingBlock;

class FallingWool extends FallingBlock
{
    /**
     * @param int $tickDiff
     * @return bool
     */
    protected function entityBaseTick(int $tickDiff = 1): bool
    {
        if ($this->isClosed()) return false;

        if (!$this->isFlaggedForDespawn()) {
            $world = $this->getWorld();

            $x = -$this->size->getWidth() / 2;
            $y = $this->size->getHeight();
            $z = -$this->size->getWidth() / 2;

            $pos = $this->location->add($x, $y, $z)->floor();

            $this->block->position($world, $pos->x, $pos->y, $pos->z);

            if ($this->onGround) $this->flagForDespawn();
        }

        return true;
    }
}