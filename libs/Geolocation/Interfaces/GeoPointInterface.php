<?php

namespace AnthonyMartin\GeoLocation\Interfaces;

use AnthonyMartin\GeoLocation\GeoPoint;
use AnthonyMartin\GeoLocation\Polygon;

interface GeoPointInterface
{
    public function inPolygon(Polygon $polygon);

    public function distanceTo(GeoPoint $geopoint, $unitofmeasure);
}
