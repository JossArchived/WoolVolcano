<?php

namespace jossc\volcano\task;

use jossc\volcano\entity\CustomFallingWoolBlock;
use jossc\volcano\utils\Utils;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\scheduler\Task;

class VolcanoTak extends Task {

    /*** @var Player */
    private $player;

    /*** @var Level */
    private $world;

    /*** @var array */
    private $fallingBlocks = [];

    /*** @var int */
    private $amount = 100;

    /**
     * VolcanoTak constructor.
     * @param Player $player
     * @param Level $world
     */
    public function __construct(Player $player, Level $world) {
        $this->player = $player;
        $this->world = $world;
    }

    /*** @param int $currentTick */
    public function onRun(int $currentTick)
    {
        if ($this->isExecutable()) {

            $location = $this->player->getLocation();

            $fallingWool = Utils::generateFallingWoolBlock($location);
            array_push($this->fallingBlocks, $fallingWool);

            Utils::playSound("liquid.lavapop", $this->player);

            $this->amount--;

            return;
        }

        $this->getHandler()->cancel();

        foreach ($this->fallingBlocks as $fallingBlock) {
            if (!$fallingBlock instanceof CustomFallingWoolBlock) {
                continue;
            }

            if (!$fallingBlock->isFlaggedForDespawn()) {
                $fallingBlock->flagForDespawn();
            }
        }
    }


    /*** @return bool */
    private function isExecutable(): bool {
        $player = $this->player;
        $amount = $this->amount;

        return ($amount >= 1) &&
            ($player->isOnline()) &&
            ($player->getLevel() === $this->world);
    }
}