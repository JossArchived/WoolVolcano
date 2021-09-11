<?php

namespace jossc\volcano\task;

use jossc\volcano\entity\CustomFallingWoolBlock;
use jossc\volcano\utils\Utils;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\world\World;

class VolcanoTak extends Task {

    /*** @var Player */
    private Player $player;

    /*** @var World */
    private World $world;

    /*** @var array */
    private array $fallingBlocks = [];

    /*** @var int */
    private int $amount = 100;

    /**
     * VolcanoTak constructor.
     * @param Player $player
     * @param World $world
     */
    public function __construct(Player $player, World $world) {
        $this->player = $player;
        $this->world = $world;
    }

    public function onRun(): void {
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
            ($player->getWorld() === $this->world);
    }
}