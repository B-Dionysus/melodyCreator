# Melody creation
[![License: CC BY 4.0](https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by/4.0/)
## Description
I was having rouble practicing my sight reading, because if the music was too complicated then I wouldn't be able to play it. By the time my slow fingers found the right notes, the tempo would drop so slow that I coulnd't hear the melody any more. However, if I found something more simple to try to read then after two or three times through I'd have the whole thing memorized. A very handy skill, no doubt, but it meant that before long I was no longer practicing sight reading!

My simple solution was to write a program to randomly generate short, simple melodies that I could play through one or twice before generating a new one. It choose a key and a time signature (from either common or waltz time) at random, and starts and ends the piece with the tonic of that key. In between, it chooses random notes at random time values. However, these choices are weighted by the sliders at hte bottom of the page so you can say, "Never jump up an octave; each note should be either a third or a fifth above the previous one". In addition, you can weight the time values, to say, "Only ever play eighth notes" or what you will. The caveate is that it will insist on filling each measure. So if it's in 4/4, and it has already picked a half note and an eighth note, it will pick another eighth note no matter what you've told it to do.

There are a number of other areas in which the purely random choice of notes is overridden. For example, having two eightnotes that are an octave apart sounds *terrible*, so that's hardcoded to not happen. As an experiment, I also made it highly likely that all half notes will be dominant tones. That sounded a lot better, so I left it in. There are a few other, similar, tweaks, and they all play off of each other, so it's still quite hard to predict.

The title is chosen randomly from words in the [NOW corpus](https://www.english-corpora.org/now/), and the midi playback is done via [Wild Web Midi](https://github.com/zz85/wild-web-midi).
## Table of Contents
* [Description](#description)
* [Live URL](#Live%20URL)
* [Testing Instructions](#Testing%20Instructions)
* [Contribution Instructions](#How%20to%20Contribute)
* [Next Steps](#Next%20Steps)
* [Screenshot](#Screenshot)
* [License](#License)
* [Questions](#Questions)
## Live URL
http://bork.hampshire.edu/~damien/sixbynine/piano/sightReading/sightReading.php
## Installation Instructions
The initial file to launch is "sightReading.php". It will call the others, as needed. Once it has generated a new melody, click on the notes to hear it.
## How to Contribute
I'm not necessarily maintaining this, and consider the project closed. For now. However, you should absolutely fork it if you would like! Just shoot me an email, if you don't mind.
## Next Steps
For all that I *just* said the project was closed, I do have a to-do list incase I ever get bored. The main thing would be to port this to javascript, probably into a react app. That would make it a lot easier to clean up the UI, I think. Would be great (and maybe not too hard) to turn it into a PWA, as well. I don't think there is a lot more to do with the fundamental melody generatin, however--it works great for what it is, but for a more serious application this is not a good approach. I'd love to have a full harmony / counterpoint system, as well, but I think it would be better to incorporate that sort of thing from the beginning, instead of bolting it on later.
## Screenshot
![screnshot](https://lh3.googleusercontent.com/rBVjUsFACTW_rEPRHPAvbFX1EoefV8g5j2R7ETZlXMBB12dN79xfj2FtCI1aqWthVOFzudTY0FO1I6rIGvxyIButdfjZTDfDyuGElIcIyZyf8q718it6qEXjRpxbQvUvQAYmQL6bZWRCUSwpvT3GxLmMsw-B4l_Upd_TNONIvPr3AQfxd-CGWR6AtGUzSGcYxukkgWebGwR2DovrHoTwFBFcQVPq3WEQwNoY5Fc0GUqz63egDRWngCH4jkpzuKvgXSMfiYzmrB5qJmOUVGRwCPE8-or2SwE-TpuZS7dXXfPhmDxKxFnXvIZKojpn6pPoKbwlocAFzpGIagNvBNbiLl_yVPYxdvcL5pqgUQFjlmR2M_33pDNoeD3qr81mpYcRC6yBI327sax4x2bUlJEqm95KBjW6wT9Am6NyR8w1dCMUX2apU7Mm9mhbYHp6lWgsk7WX-_QoLSEkZ6HvonvndsYH8IO2p1dK-_ggpggNGDG1tew1ePZxPFwtVsSX5PqZWiDhkF7YAhREKzbS0Oq5kZ-lTZZAca1bPoz23jXb7irNYrdRMEoUzPy6kIT1knwMnJIHFxjO2dlDkq8bSXovNiiKSEoQYCiUOm4IpUleFvZpnVHUeS2XPaVSRBYn-Qxf-5ld_20jZyu-ej3DNU9xaj9kbjTwExq6ncpO1maEHPfRHAmA59PoSvSi8NFsgg=w924-h738-no?authuser=0)
## License
License: CC BY 4.0
## Questions
Please contact github@sixbynine.com.
Other projects I've worked on are here: https://github.com/B-Dionysus.
