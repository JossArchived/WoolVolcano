<?php

namespace jossc\volcano\utils;

use jossc\volcano\entity\CustomFallingWoolBlock;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\Location;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class Utils {

    /**
     * @param Location $location
     * @return CustomFallingWoolBlock
     */
    public static function generateFallingWoolBlock(Location $location): CustomFallingWoolBlock {
        $nbt = EntityDataHelper::createBaseNBT($location->asVector3());

        $fallingBlock = new CustomFallingWoolBlock(
            $location,
            BlockFactory::getInstance()->get(BlockLegacyIds::WOOL, rand(0, 15)),
            $nbt
        );

        $fallingBlock->setMotion(new Vector3(
                -sin(mt_rand(1, 360) / 60 * M_PI),
                0.95,
                cos(mt_rand(1, 360) / 60 * M_PI))
        );

        $fallingBlock->spawnToAll();

        return $fallingBlock;
    }

    /**
     * @param string $soundName
     * @param Player $player
     */
    public static function playSound(string $soundName, Player $player): void {
        $location = $player->getLocation();

        $pk = new PlaySoundPacket();
        $pk->soundName = $soundName;
        $pk->volume = 1;
        $pk->pitch = 1;
        $pk->x = $location->x;
        $pk->y = $location->y;
        $pk->z = $location->z;

        $player->getNetworkSession()->sendDataPacket($pk);
    }
}