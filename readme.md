![screen shot 2017-07-29 at 20 15 59](https://user-images.githubusercontent.com/7118482/28747275-336ba6a8-749b-11e7-8f2b-5b76f96137da.png)

Dungeons of Arvum is a roguelike-inspired realtime multiplayer browser game currently under "hobby development".

## Game footage
![doa](https://user-images.githubusercontent.com/7118482/30783785-3955baf6-a149-11e7-97f3-832a509420b7.gif)

Essentially, Dungeons of Arvum allows you to play with your friends in a possibly huge single floor dungeon. You fight mobs, level up, gather items, spells and potions. 

The goal is to be the last man standing. However, the dungeon is so big that you might be hard pressed to locate other players right away. Should you level and gear up, to become more powerful, or should you chase around looking for the other players right as you spawn? It's up to you!

## Requirements
PHP 7.0 is required. The server only runs on 7.0 at the moment, and not any other version. This will change in the future, as the code is optimized.

## Getting started
Simply download this repository and start up the server by either opening the "run" file or typing "php server.php" from the terminal. Make sure the requirements are met beforehand, and that you've set your IP, port and wanted dungeon size in config.php.

Then ask your players to head on over to [http://simonpacis.github.io/Dungeons-of-Arvum](http://simonpacis.github.io/Dungeons-of-Arvum), and tell them your public-facing IP address and port number.

In case you're looking for a simple way to install and run Dungeons of Arvum on a Ubuntu system, here's a oneliner that will set everything needed up for you, and run the server.
```
sudo add-apt-repository ppa:ondrej/php && sudo apt-get update && sudo apt-get install php7.0-fpm libfontconfig && git clone https://github.com/simonpacis/Dungeons-of-Arvum && cd Dungeons-of-Arvum && ./run
```

With this you can whip up a VPS on something like DigitalOcean, run the oneliner, give people your IP-address, and play away!

They enter the IP and port like this: "IP:PORT". If the port is omitted, it will default to 9300.
(If the client seems to crash after they've entered the IP-address and pressed enter, please read the note at the bottom of this page.)

Note: The first time you run the server, it will try to download a phantomjs binary for your OS. It can do so for macOS and Linux, but Windows users have to put a working phantomjs binary in the "libs" folder themselves. If someone with a Windows box can automate this, please be my guest and send a PR – the code is in the mapfunctions.php file.

## FAQ
#### Game ticks?
So, in trying to stay true to the roguelike roots, Dungeons of Arvum only issues a game tick whenever a player hits a key. So, if no one does anything, the game is essentially paused.

## Known bugs
- The server crashes if a dead player tries to move.
- Lag can occur if a lot of action is going on in the game, a workaround is to run the server on a more powerful machine.

## Client seems to crash/freeze
The client has probably been loaded over HTTPS, instead of HTTP. It is **important** that it is loaded over HTTP. If it is not, you have to use WebSockets Secure instead of regular WebSockets. This requires a more complicated setup, and is not supported at the moment.

If Chrome persists on wanting to show your players a HTTPS version of the client, either host it yourself or make them open the link in incognito mode; this seems to solve the issue for some users.
