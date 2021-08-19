<?php

namespace jossc\volcano\listener;

use jossc\volcano\WoolVolcano;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class EventListener implements Listener {

    /*** @var WoolVolcano */
    private $instance;

    /**
     * EventListener constructor.
     * @param WoolVolcano $instance
     */
    public function __construct(WoolVolcano $instance) {
        $this->instance = $instance;
    }

    /*** @param PlayerChatEvent $event */
    public function PlayerChatEvent(PlayerChatEvent $event): void {
        $player = $event->getPlayer();

        if (!$player->getServer()->isOp($player->getName())) {
            return;
        }

        if ($event->getMessage() != "volcano") {
            return;
        }

        $event->cancel();

        $this->instance->giveTo($player);
    }
}