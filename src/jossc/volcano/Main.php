<?php

namespace jossc\volcano;

use jossc\volcano\entity\CustomFallingWoolBlock;
use jossc\volcano\listener\EventListener;
use jossc\volcano\task\VolcanoTak;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {

    /*** @var Main */
    private static $main;

    public function onEnable()
    {
        parent::onEnable();

        self::$main = $this;

        $this->registerEntity();

        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener($this),
            $this
        );

        $this->getLogger()->info(TextFormat::GREEN . 'This plugin has been enabled!.');
    }

    public function onDisable(): void {
        parent::onDisable();

        $this->getLogger()->info(TextFormat::RED . 'This plugin has been disabled!.');
    }

    private function registerEntity(): void {
        Entity::registerEntity(CustomFallingWoolBlock::class, true);
    }

    /*** @return Main */
    public static function getInstance(): Main {
        return self::$main;
    }

    /*** @param Player $player */
    public function giveTo(Player $player): void {
        $this->getScheduler()->scheduleDelayedRepeatingTask(
            new VolcanoTak($player, $player->getLevel()), 0, 2
        );
    }
}