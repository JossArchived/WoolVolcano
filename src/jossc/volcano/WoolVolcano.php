<?php

namespace jossc\volcano;

use jossc\volcano\listener\DefaultListener;
use jossc\volcano\task\VolcanoTak;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class WoolVolcano extends PluginBase implements Listener
{
    /*** @var WoolVolcano */
    private static $instance;

    /*** @return WoolVolcano */
    public static function getInstance(): WoolVolcano
    {
        return self::$instance;
    }

    protected function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents(new DefaultListener($this), $this);

        $this->getLogger()->info(TextFormat::GREEN . 'This plugin has been enabled!.');
    }

    /*** @param Player $player */
    public function giveTo(Player $player): void
    {
        $defaultWorld = $this->getServer()->getWorldManager()->getDefaultWorld();
        $this->getScheduler()->scheduleDelayedRepeatingTask(new VolcanoTak($player, $defaultWorld), 0, 4);
    }

    protected function onDisable(): void
    {
        $this->getLogger()->info(TextFormat::RED . 'This plugin has been disabled!.');
    }
}