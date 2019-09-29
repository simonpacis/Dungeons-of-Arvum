The following are major updates and changes coming to Dungeons of Arvum in the future.

# The Spell Update
*Status*: Active

The spell update is already in progress, and wants to overhaul the way spells work. At first, I thought it would be nice for the players to have loads of different spells to learn, and so I added a lot of different spell scrolls (that you learn spells from). In playtesting, this turned out to be a bad idea. It's too complicated. So, now there's going to be three different spell branches. You can read more on the thoughts regarding these branches in the wiki.

# The Combat Update
*Status*: Pending

Combat works relatively fine in Dungeons of Arvum. But, you can shoot through walls, and oftentimes a tick occurs right when you attack, so a mob moves outside of your radius without you being able to tell beforehand. This might waste mana and ammo. Mobs will also often hug you, and just stand really close to you without attacking you. These things will be fixed by this update.

# The Content Update
*Status*: Pending

A lot of items have no price. Monsters have random HP and damage. Weapons are wildly inconsistent. A lot of more content is going to be added, monsters, items, shops and characters. And all this will have to be balanced. It's going to be great!

# The Threaded Update
*Status*: Pending

Dungeons of Arvum is single-threaded. It calculates everything for one player, then the next player, the next player and the next player. And it does this every time any player hits a key on their keyboard. With a lot of players and a lot of action this is a recipe for disaster.

Dungeons of Arvum has always been a fun hobby project, and so not a lot of planning and thought has gone into it. The development methodolgy is essentially: If it works, it's done.

But, I would like to reimplement large parts of the core game code so that it's threaded. Each player gets their own thread, so that calculations and the game can become faster. This is down the line, but know that I'm thinking about it.