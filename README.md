TwitchStreamer Workflow for [Alfred 2](http://www.alfredapp.com)
==============================

## In Short
* Search Twitch.TV streams and watch in [VLC](http://www.videolan.org/vlc/index.html) ([Livestreamer](https://github.com/chrippa/livestreamer) required)

* keywords: `tw`, `twtop`, `twgames`, optional: `twbygame`, `twcover`

* `twtop`: show top live streams on twitch.tv

* `twgames`: show top live games streamed on twitch.tv

* `tw`: search specific live stream/game on twitch.tv (argument: game, channel or streamer)

* `twbygame`: search streams by game, result leads to `tw `

* `twcover`: download game icons/covers/posters (optional, you only have to use it once you want to download many new game covers => e.g. because you deleted your outdated cover-folder)

* browse philosophy: `twtop` or `twgames` for getting the most wanted streams on twitch.tv

* search philosophy: `tw star` finds streamer like "starman" and "starcraft"-games streams


## Details

Check who is streaming on Twitch.Tv (category gaming) and watch your favorite stream via [Livestreamer](https://github.com/chrippa/livestreamer) on [VLC](http://www.videolan.org/vlc/index.html) (no lags anymore, thanks to buffering).

The main keyword is `tw` and the second word is the game or stream you want to watch (examples: `tw voyboy` or `tw league of legends` or also simply `tw league`). Alternative: Use keyword `twtop` to see the current TOP streams or `twgames` for the current TOP streamed games. Limit of streams is changable via specific workflow ($limit-variable).

With `enter` you can open the stream via Terminal ([Livestreamer](https://github.com/chrippa/livestreamer)) on [VLC](http://www.videolan.org/vlc/index.html). The Terminal has not to be open while you are watching the stream. But because of Terminal's nature you need to change its settings first, to force the Terminal to shutdown automatically: Just open Terminal and go to Terminal > Preferences > Profiles or Settings > Shell: > When the shell exits: -> Close if the shell exited cleanly.

The streamer list is sorted by number of viewers descending. The quality of the stream is "high". If you want to change it to best (e.g.), feel free to open the existing "Terminal Command" (alfred, workflow-window) and modify the Livestreamer line.

Optional: If you deleted your game icons/covers/posters folder (because many of them are outdated) you should use `twcover` to download all the top game covers. Otherwise `tw ` or `twtop` will do it, but it takes more time and downloads less covers. 


## Screenshot: Browsing TOP STREAMS
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow1.jpg)

## Screenshot: Browsing TOP GAMES
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow4.jpg)

## Screenshot: Searching STREAM
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow3.jpg)

## Screenshot: Searching GAME
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow2.jpg)

## Screenshot: Downloading GAME COVERS/POSTERS
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow5.png)

## Screenshot: Watching STREAM
![Workflow Screenshot](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/screenshots/workflow6.jpg)


## Download

Required: [Livestreamer](https://github.com/chrippa/livestreamer) and [VLC](http://www.videolan.org/vlc/index.html)

Made in/with OSX 10.9.1, livestreamer 1.11.1, VLC 2.1.2, PHP 5.3, AppleScript 2.3, Twitch-API/v3

Supports AlleyOop/[Monkey Patch](http://www.alfredforum.com/topic/2218-monkey-patch-update-alfred-workflows-via-alleyoop/) (workflow updater).

**[DOWNLOAD HERE](https://raw.githubusercontent.com/eusi/alfred2-twitch-streamer/master/workflow/TwitchStreamer.alfredworkflow)**

## Issues

* it takes a lil time between entries because of the twitch.tv-api


## Contacts

If you have found bugs/issues or if you just want to say "hello" so send me an email: eusi.cf@gmail.com

<a href="https://github.com/eusi"><img src="https://2.gravatar.com/avatar/d954b2ec10b10436505ae62fe972df97?d=https%3A%2F%2Fidenticons.github.com%2Fe098fc2b57681a6f25ba17badf99aa6f.png&r=x&s=440" alt="eusi" title="eusi" width="100" height="100"></a>


## License

GNU General Public License version 3



#Changelog

## 1.71

* Minor update
* Added support for mpv playback (thx@ Jonathan Dahan)

## 1.7

* Changed vjpg-branch to master
* Modified terminal command: Quits Terminal automatically 
* Deleted `twgame`
* Added `twgames` (top streamed games by viewers)
* Added `twbygame`, similar to the old `twgame`

## 1.6.1

* Modified terminal command: Terminal must no longer stay open (thx@ mclowe-directnic)
* Added some covers.
* Fixed updater (json).

## 1.6.0

* Switched cover-format from png to jpg (due to issue#1)
* Cleaned up code

## 1.5.0 - 1.5.2

* Big Update
* Added `twgame`.
* Added `twcover` (downloads and converts game covers).
* Fixed sort order bug, thanks to tyler and andrew.
* Added some covers.

## 1.3.0

* Big Update (reworked the whole code).
* Added `twtop`.
* `tw` searches more efficient and games as well as streams.

## 1.1.0

* First real release without webserver.
* Added AlleyOop/[Monkey Patch](http://www.alfredforum.com/topic/2218-monkey-patch-update-alfred-workflows-via-alleyoop/) support (workflow updater).
* Downgraded Workflows from 0.32 to 0.3 due to a sort-bug.

## 0.5.0

* First release with all functions. Based on stream-parsing on webserver.
