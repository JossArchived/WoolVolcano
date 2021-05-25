<?php

namespace jossc\volcano\entity;

use pocketmine\entity\object\FallingBlock;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;

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

            $blockTarget = null;

            if ($this->onGround || $blockTarget !== null) {
                $this->flagForDespawn();

                $block = $world->getBlock($pos);

                if (!$block->canBeReplaced() || !$world->isInWorld($pos->getFloorX(), $pos->getFloorY(), $pos->getFloorZ())
                    || ($this->onGround && abs($this->location->y - $this->location->getFloorY()) > 0.001)
                ){
                    $air = new Item(new ItemIdentifier(0, 0));

                    $world->dropItem($this->location, $air);
                }
            }
        }

        return true;
    }
}