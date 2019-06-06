<?php

require_once("TurkeySub.php");
require_once("VeggieSub.php");

(new TurkeySub())->make();
echo "\n <=====> \n";
(new VeggieSub())->make();
