<?php

namespace jossc\volcano\task;

use jossc\volcano\utils\Utils;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\Location;
use pocketmine\entity\object\FallingBlock;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\World;

class VolcanoTak extends Task
{
    /*** @var Player */
    private $player;
    /*** @var World */
    private $world;
    /*** @var array */
    private $blocks = [];
    /*** @var int */
    private $amount = 70;

    /**
     * VolcanoTak constructor.
     * @param Player $player
     * @param World $world
     */
    public function __construct(Player $player, World $world)
    {
        $this->player = $player;
        $this->world = $world;
    }

    private function isExecutable(): bool
    {
        $player = $this->player;
        $amount = $this->amount;

        return ($amount >= 1) && ($player->isOnline()) && ($player->getWorld() === $this->world);
    }

    public function onRun(): void
    {
        if (!$this->isExecutable())  {
            $this->getHandler()->cancel();

            foreach ($this->blocks as $block) {
                if (!$block instanceof FallingBlock) continue;

                if (!$block->isFlaggedForDespawn()) {
                    $block->flagForDespawn();

                    continue;
                }

                if ($block->isOnGround()) {
                    $this->world->setBlock(
                        $block->getBlock()->getPos(),
                        BlockFactory::getInstance()->get(BlockLegacyIds::AIR, 0), true
                    );
                }
            }
        } else {
            $player = $this->player;

            $fallingBlock = $this->generateFallingBlock($player->getLocation());
            array_push($this->blocks, $fallingBlock);

            Utils::playDefaultSound($player);
        }

        $this->amount--;
    }

    private function generateFallingBlock(Location $location): FallingBlock
    {
        $nbt = EntityDataHelper::createBaseNBT($location->asVector3());

        $meta = rand(0, 15);
        $fallingBlock = new FallingBlock($location, BlockFactory::getInstance()->get(BlockLegacyIds::WOOL, $meta), $nbt);

        $x = (double) rand(-1.5, 1.5);
        $z = (double) rand(-1.5, 1.5);
        $fallingBlock->setMotion(new Vector3($x, (double) 0.75, (double) $z));

        $fallingBlock->setRotation(rand(1, 360), rand(1, 360));

        $fallingBlock->setForceMovementUpdate(true);
        $fallingBlock->setSilent(true);

        $fallingBlock->setCanClimb(false);
        $fallingBlock->setCanClimbWalls(false);

        if (!$fallingBlock->isInsideOfSolid()) {
            $fallingBlock->spawnToAll();
        }

        $fallingBlock->setCanSaveWithChunk(false);

        return $fallingBlock;
    }
}