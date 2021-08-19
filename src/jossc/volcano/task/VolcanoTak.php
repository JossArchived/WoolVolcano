<?php

namespace jossc\volcano\task;

use jossc\volcano\entity\FallingWool;
use jossc\volcano\utils\Utils;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\World;

class VolcanoTak extends Task {

    /*** @var Player */
    private $player;
    /*** @var World */
    private $world;
    /*** @var array */
    private $fallingBlocks = [];
    /*** @var int */
    private $amount = 100;

    /**
     * VolcanoTak constructor.
     * @param Player $player
     * @param World $world
     */
    public function __construct(Player $player, World $world) {
        $this->player = $player;
        $this->world = $world;
    }

    /*** @return bool */
    private function isExecutable(): bool {
        $player = $this->player;
        $amount = $this->amount;

        return ($amount >= 1) &&
            ($player->isOnline()) &&
            ($player->getWorld() === $this->world);
    }

    public function onRun(): void {
        if (!$this->isExecutable()) {
            $this->getHandler()->cancel();

            foreach ($this->fallingBlocks as $fallingBlock) {
                if (!$fallingBlock instanceof FallingWool) {
                    continue;
                }

                if (!$fallingBlock->isFlaggedForDespawn()) {
                    $fallingBlock->flagForDespawn();
                }
            }

            return;
        }

        $player = $this->player;
        $location = $player->getLocation();
        $fallingWool = $this->generateFallingWool($location);
        array_push($this->fallingBlocks, $fallingWool);

        Utils::playSound("liquid.lavapop", $player);

        $this->amount--;
    }

    /**
     * @param Location $location
     * @return FallingWool
     */
    private function generateFallingWool(Location $location): FallingWool {
        $nbt = EntityDataHelper::createBaseNBT($location->asVector3());

        $meta = rand(0, 15);
        $fallingBlock = new FallingWool(
            $location,
            BlockFactory::getInstance()->get(BlockLegacyIds::WOOL, $meta),
            $nbt
        );

        $fallingBlock->setMotion(new Vector3(
            -sin(mt_rand(1, 360) /60 * M_PI),
            0.95,
            cos(mt_rand(1, 360) / 60 * M_PI))
        );

        $fallingBlock->setForceMovementUpdate(true);
        $fallingBlock->setSilent(true);
        $fallingBlock->setCanSaveWithChunk(false);

        $fallingBlock->spawnToAll();

        return $fallingBlock;
    }
}