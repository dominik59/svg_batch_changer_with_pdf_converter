# Svg Batch Changer With Pdf Converter

Hi. I would like present You a module for batch changing SVG files (but can be used for any conversion).

# Installation

I suggest You to clone that repository to environment which can handle PHP and simply type:
```
php script.php
```
It will change Your previously set file and save it to location which You have set.

You can make use from options below:

| Option | What it matters |

| ------ |     ------      |

| -c     | Set on conversion to PDF each of new changed file |

Example:
```
php script.php -c
```
With basic settings it will take template from **templates/template.html.twig** change all parameters, save changed svg files to **svg** folder and convert each of these files to **pdf** folder.

Any pull requests all welcomed :)
