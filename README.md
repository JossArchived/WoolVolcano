# WoolVolcano

Victory effect for your Minecraft BE server, inspired by Cubecraft, for Pocketmine 3.0.0

If you encounter any bugs, have suggestions or questions, [create an issue](https://github.com/Josscoder/WoolVolcano/issues/new).

## Setup

1) Download the latest version [here](https://github.com/Josscoder/WoolVolcano/releases/latest)
2) Put the .phar in your plugins folder
3) And finally, start your server!

## How can I preview?

Only operator players can write "volcano" without quotes in the server chat.
[Here](https://twitter.com/Josscoder/status/1397231329180364801) is an example video

## For developers

With the following code you can give the win effect to the player:
````php
\jossc\volcano\Main::getInstance()->giveTo($player);
````
