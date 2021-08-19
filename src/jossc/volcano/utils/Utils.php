<?php

namespace jossc\volcano\utils;

use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class Utils {

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