<?php

namespace jossc\volcano;

use jossc\volcano\entity\CustomFallingWoolBlock;
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

class Main extends PluginBase {

    /*** @var Main */
    private static $main;

    protected function onEnable(): void{
        self::$main = $this;

        $this->registerEntity();

        $this->getServer()->getPluginManager()->registerEvents(
            new EventListener($this),
            $this
        );

        $this->getLogger()->info(TextFormat::GREEN . 'This plugin has been enabled!.');
    }

    private function registerEntity(): void {
        EntityFactory::getInstance()->register(CustomFallingWoolBlock::class,
            function(World $world, CompoundTag $nbt) : CustomFallingWoolBlock {
            return new CustomFallingWoolBlock(
                EntityDataHelper::parseLocation($nbt, $world),
                BlockFactory::getInstance()->get(BlockLegacyIds::WOOL, 0),
                $nbt
            );
        }, ['CustomFallingWoolBlock', 'minecraft:falling_wool_block_entity']);
    }

    /*** @return Main */
    public static function getInstance(): Main {
        return self::$main;
    }

    /*** @param Player $player */
    public function giveTo(Player $player): void {
        $this->getScheduler()->scheduleDelayedRepeatingTask(
            new VolcanoTak($player, $player->getWorld()), 1, 3
        );
    }

    protected function onDisable(): void {
        $this->getLogger()->info(TextFormat::RED . 'This plugin has been disabled!.');
    }
}