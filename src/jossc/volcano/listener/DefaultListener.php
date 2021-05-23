<?php

namespace jossc\volcano\listener;

use jossc\volcano\WoolVolcano;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat;

class DefaultListener implements Listener
{
    /*** @var WoolVolcano */
    private $instance;

    public function __construct(WoolVolcano $instance)
    {
        $this->instance = $instance;
    }

    /*** @param PlayerChatEvent $event */
    public function PlayerChatEvent(PlayerChatEvent $event): void
    {
        $player = $event->getPlayer();

        if (!$player->getServer()->isOp($player->getName())) return;

        if ($event->getMessage() != "volcano") return;

        $event->cancel();

        $this->instance->giveTo($player);
        $player->sendMessage(TextFormat::RED . 'A wool volcano is about to explode!.');
    }
}