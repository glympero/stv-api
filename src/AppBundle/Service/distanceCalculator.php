<?php

namespace AppBundle\Service;

use PHPCoord\OSRef;

class distanceCalculator
{
    function getDistanceFromPQ($eastings, $northings) {
        $firstPostcode = new OSRef($eastings, $northings);
        $stvOSRef = new OSRef(257043, 664991); //stv's easting and northings

        return round($stvOSRef->distance($firstPostcode));
    }
}