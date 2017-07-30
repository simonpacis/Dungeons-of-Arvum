![screen shot 2017-07-29 at 20 15 59](https://user-images.githubusercontent.com/7118482/28747275-336ba6a8-749b-11e7-8f2b-5b76f96137da.png)

Dungeons of Arvum is a roguelike-inspired realtime multiplayer browser game currently under "hobby development".

## Game footage
![doa](https://user-images.githubusercontent.com/7118482/28747280-52bb981a-749b-11e7-9860-06ee03a18ef0.gif)

Essentially, Dungeons of Arvum allows you to play with your friends in a huge (possible dungeon size depends on computer and amount of players; see table below) single floor dungeon. You fight mobs, level up, gather items, spells and potions. 

The goal is to be the last man standing. However, the dungeon is so big that you might be hard pressed to locate other players right away. Should you level and gear up, to become more powerful, or should you chase around looking for the other players right as you spawn? It's up to you!

## Getting started
The Dungeons of Arvum server is written in PHP, and is run from the terminal. Simply download this repository and start up the server with the following terminal command:
```php server.php```
And Dungeons of Arvum starts right up. Ask your players to head on over to [http://simonklitjohnson.github.io/Dungeons-of-Arvum](http://simonklitjohnson.github.io/Dungeons-of-Arvum), and tell them your public-facing IP address. If the client seems to crash after they've entered the IP-address and pressed enter, please read the note at the bottom of this page.

Note: If the game crashes at "Generating map", you need to get the correct phantomjs binary for your OS. Drop it in the "DoA/libs" folder, and then run the server again. They can be downloaded here: [http://phantomjs.org/download.html](http://phantomjs.org/download.html). The binary included is for macOS, however it has proved to work on other OS'es too. In the future, the requirement for phantomjs will not be present.

Make sure to set your IP and wanted dungeon size in config.php.

## Dungeon size
The size of the dungeon depends on your computers powers. The code is **not** optimized, and so it requires far more processing power to run smoothly, than you would expect.

| Computer             | Max dungeon size       |
|----------------------|------------------------|
| Macbook Pro 2012 13" | 1000x1000 w/ 4 players |
| Macbook Pro 2012 15" | 2000x2000 w/ 4 players |

## Client seems to crash/freeze
The client has probably been loaded over HTTPS, and not HTTP. It is **important** that it is not loaded over HTTPS. If it is, you are not allowed to use regular WebSockets, but have to use WebSockets Secure. This requires a more complicated setup, and is not supported at the moment.

If Chrome persists on wanting to show your players a HTTPS version of the client, either host it yourself or make them open the link in incognito mode; this seems to solve the issue for some users.
