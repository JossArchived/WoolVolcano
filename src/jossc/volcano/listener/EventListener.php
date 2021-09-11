<?php

namespace jossc\volcano\listener;

use jossc\volcano\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;

class EventListener implements Listener {

    /*** @var Main */
    private Main $main;

    /**
     * EventListener constructor.
     * @param Main $main
     */
    public function __construct(Main $main) {
        $this->main = $main;
    }

    /*** @param PlayerChatEvent $event */
    public function onChat(PlayerChatEvent $event): void {
        $player = $event->getPlayer();

        if (!$player->getServer()->isOp($player->getName())) {
            return;
        }

        if ($event->getMessage() != "volcano") {
            return;
        }

        $event->cancel();

        $this->main->giveTo($player);
    }
}