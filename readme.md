# Melody creation
[![License: CC BY 4.0](https://img.shields.io/badge/License-CC%20BY%204.0-lightgrey.svg)](https://creativecommons.org/licenses/by/4.0/)
## Description
I was having rouble practicing my sight reading, because if the music was too complicated then I wouldn't be able to play it. By the time my slow fingers found the right notes, the tempo would drop so slow that I coulnd't hear the melody any more. However, if I found something more simple to try to read then after two or three times through I'd have the whole thing memorized. A very handy skill, no doubt, but it meant that before long I was no longer practicing sight reading!

My simple solution was to write a program to randomly generate short, simple melodies that I could play through one or twice before generating a new one. It chooses a key and a time signature (from either common or waltz time) at random, and starts and ends the piece with the tonic of that key. In between, it chooses random notes at random time values. However, these choices are weighted by the sliders at the bottom of the page. So you can say, "Never jump up an octave; each note should be either a third or a fifth above the previous one". In addition, you can weight the time values, to say, "Only ever play eighth notes" or what you will. The caveate is that it will insist on filling each measure. So if it's in 4/4, and it has already picked a half note and three eighth notes, it will pick a fouth eighth note no matter what you've told it to do.

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
![scrrenshot](https://lh3.googleusercontent.com/fife/ABSRlIo5nDA6SjvUm-H3jC69xW9nlcPVl75zCnHShtj-cRQYyB5ISpk5oRoVs6lNKhXpCjfqEFDiV8CSER2ymaql5B7hptGOmihDDkYsglyBny-rE_dXSlpIxxOWbuQPvIiGN3FtzWSAKkltuZKBY5SNrpSSG5N8UT7Cuc-ANe6vs_O744nj7KGS5Rj2_jxJeg8-uF40xknxMbEDb5f_Eay3J5UjCAA66dcvagNdVYw6mGl9_t3pXQCyG6BgWJiysk4E-Q-SeYcPAUsapJ1giiSlHbN6YWzdGK5liM_1qm2fFDXVr3D7Z_jm0aG2Hx3HU_QVdS3eISLy6Ys64VngApdSqheosvEje7iZDPD9TN9zFnFPdj-sy8qAp0sD-umJ_tAT4jOOfCyur7OWCbhWO4Os9xfzJnykZVZoR5ghF8-ymATCQhl0FPBy2mtu-XqYUB3gLsPtOttTWQEIijtkEfj8C2mx3OzNoOoKWM5C1gOh53UeeU4_eAspYcr_OYgQHn1NsZBEmhDmybXBVvBug_dWM7qe7FekbG1hC6ee7k38cyckKrUHL3mDocThd_1yMkyRbQ9Nh7L6Rbkw5TpbWfjAu-9cWmtwYIZsg_uj053EZdoy6EmQ_zJWGwbZCUuJo84YaxIq_VsPL5kswQR3qeV7GDhqxme99iv7hAs0h9_4kLAqGq0UX-GuEm8Rhe9GK9u3B7rksSTp7OkkKVejMPWZrD9k-W3PrdIz8w=s924-w924-h738)
## License
License: CC BY 4.0
## Questions
Please contact github@sixbynine.com.
Other projects I've worked on are here: https://github.com/B-Dionysus.
