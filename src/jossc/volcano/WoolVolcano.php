<?php

namespace jossc\volcano;

use jossc\volcano\entity\FallingWool;
use jossc\volcano\listener\EventListener;
use jossc\volcano\task\VolcanoTak;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockLegacyIds;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\world\World;

class WoolVolcano extends PluginBase {
    /*** @var WoolVolcano */
    private static $instance;

    /*** @return WoolVolcano */
    public static function getInstance(): WoolVolcano {
        return self::$instance;
    }

    protected function onEnable(): void{
        self::$instance = $this;

        $this->registerEntity();

        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);

        $this->getLogger()->info(TextFormat::GREEN . 'This plugin has been enabled!.');
    }

    private function registerEntity(): void {
        EntityFactory::getInstance()->register(FallingWool::class,
            function(World $world, CompoundTag $nbt) : FallingWool {
            return new FallingWool(
                EntityDataHelper::parseLocation($nbt, $world),
                BlockFactory::getInstance()->get(BlockLegacyIds::WOOL, 0),
                $nbt
            );
        }, ['FallingWool', 'minecraft:falling_wool_entity']);
    }

    /*** @param Player $player */
    public function giveTo(Player $player): void {
        $defaultWorld = $this->getServer()->getWorldManager()->getDefaultWorld();
        $this->getScheduler()->scheduleDelayedRepeatingTask(
            new VolcanoTak($player, $defaultWorld), 0, 2
        );
    }

    protected function onDisable(): void {
        $this->getLogger()->info(TextFormat::RED . 'This plugin has been disabled!.');
    }
}