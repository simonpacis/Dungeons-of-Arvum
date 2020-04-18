![screen shot 2017-07-29 at 20 15 59](https://user-images.githubusercontent.com/7118482/28747275-336ba6a8-749b-11e7-8f2b-5b76f96137da.png)

Dungeons of Arvum is a roguelike-inspired realtime multiplayer browser game currently under "hobby development".

## Game footage
![doa](https://user-images.githubusercontent.com/7118482/79126239-e0064200-7d9f-11ea-9214-3d54506aa65c.gif)

Essentially, Dungeons of Arvum allows you to play with your friends in a possibly huge single floor dungeon. You fight mobs, level up, gather items, spells and potions. 

The goal is to be the last man standing. However, the dungeon is so big that you might be hard pressed to locate other players right away. Should you level and gear up, to become more powerful, or should you chase around looking for the other players right as you spawn? It's up to you!

A single-player mode is currently in active development. This is great way to learn the game before playing it with someone. You can enable it now! Read more here: [Dungeons of Arvum Single-Player Mode](https://github.com/simonpacis/Dungeons-of-Arvum/wiki/Single-Player-Mode).

## Requirements
PHP 7.0 to 7.3 is supported. Any other versions of PHP are not supported at this moment.

## Getting started
Simply download this repository and start up the server by either executing the "run" file or typing "php server.php" from the terminal. Make sure the requirements are met beforehand, and that you've set your port, dungeon size and max amount of players in config.php.

Then ask your players to head on over to [http://simonpacis.github.io/Dungeons-of-Arvum](http://simonpacis.github.io/Dungeons-of-Arvum), and tell them your public-facing IP address and port number.

In case you're looking for a simple way to install and run Dungeons of Arvum on a Ubuntu system, here's a oneliner that will set everything needed up for you, and run the server.
```
sudo apt-get install php libfontconfig && git clone https://github.com/simonpacis/Dungeons-of-Arvum && cd Dungeons-of-Arvum && ./run
```

With this you can whip up a VPS on something like DigitalOcean, run the oneliner, give people your IP-address, and play away!

They enter the IP and port like this: "IP:PORT". If the port is omitted, it will default to 9300.
  
Note: The first time you run the server, it will try to download a phantomjs binary for your OS. This binary is required for map generation and tick spawning. Dungeons of Arvums can automatically download this binary on macOS and Linux, but Windows users have to put a working phantomjs binary in the "libs" folder themselves, and possibly modify the code too. I have no Windows machine, so if someone with a Windows machine can automate this, please be my guest and send a PR – the code for this can be found in the *mapfunctions.php* file.

## FAQ
#### Game ticks?
By default, the game ticks three times per second. This can be changed in config.php, by setting the boolean *constant_tick* to false. By setting it to false, the game only issues a game tick whenever a player hits a key. So, if no one does anything, the game is essentially paused.

## Known bugs
- The server crashes if a dead player tries to move.
- Lag can occur if a lot of action is going on in the game (fix is on roadmap as *The Threaded Update*). 
