# WoolVolcano
Win Effect by cubecraft, now in pocketmine

# Installation:
- Download the latest version [here](https://github.com/Josscoder/WoolVolcano/releases/latest).
- Put the WoolVolcano_v1.phar inside plugins/.
- Start the server.

# How can I preview?
Only op users can type "volcano" without quotes in chat.
[Here](https://twitter.com/Josscoder/status/1397231329180364801) is an example video

# For developers
To give the player the win effect, do:
````
WoolVolcano::getInstance()->giveTo($player);
````