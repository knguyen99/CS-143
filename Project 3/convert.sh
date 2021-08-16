#!/bin/bash

#
# Please uncomment one of the following three lines depending on the language of your choice
#

#node convert.js
python3 convert.py
dos2unix affiliations.del laureates.del nobelPrizes.del
#php convert.php