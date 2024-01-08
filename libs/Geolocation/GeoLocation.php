<?php

namespace AnthonyMartin\GeoLocation;

/**
 * <p>Represents a point on the surface of a sphere. (The Earth is almost
 * spherical.)</p>
 *
 * <p>To create an instance, call one of the static methods fromDegrees() or
 * fromRadians().</p>
 *
 * <p>This is a PHP port of Java code that was originally published at
 * <a href="http://JanMatuschek.de/LatitudeLongitudeBoundingCoordinates#Java">
 * http://JanMatuschek.de/LatitudeLongitudeBoundingCoordinates#Java</a>.</p>
 *
 * Many thanks to the original author: Jan Philip Matuschek
 *
 * @author Anthony Martin
 *
 * @version November 21 2012
 */
class GeoLocation
{
    protected $radLat;  // latitude in radians

    protected $radLon;  // longitude in radians

    protected $degLat;	 // latitude in degrees

    protected $degLon;  // longitude in degrees

    protected $angular; // angular radius

    const EARTHS_RADIUS_KM = 6371.01;

    const EARTHS_RADIUS_MI = 3958.762079;

    protected static $MIN_LAT;  // -PI/2

    protected static $MAX_LAT;  //  PI/2

    protected static $MIN_LON;  // -PI

    protected static $MAX_LON;  //  PI

    public function __construct()
    {
        self::$MIN_LAT = deg2rad(-90);   // -PI/2
        self::$MAX_LAT = deg2rad(90);    //  PI/2
        self::$MIN_LON = deg2rad(-180);  // -PI
        self::$MAX_LON = deg2rad(180);   //  PI
    }

    /**
     * @param  float  $latitude the latitude, in degrees.
     * @param  float  $longitude the longitude, in degrees.
     * @return GeoLocation
     */
    public static function fromDegrees($latitude, $longitude)
    {
        $location = new self();
        $location->radLat = deg2rad($latitude);
        $location->radLon = deg2rad($longitude);
        $location->degLat = $latitude;
        $location->degLon = $longitude;
        $location->checkBounds();

        return $location;
    }

    /**
     * @param  float  $latitude the latitude, in radians.
     * @param  float  $longitude the longitude, in radians.
     * @return GeoLocation
     */
    public static function fromRadians($latitude, $longitude)
    {
        $location = new self();
        $location->radLat = $latitude;
        $location->radLon = $longitude;
        $location->degLat = rad2deg($latitude);
        $location->degLon = rad2deg($longitude);
        $location->checkBounds();

        return $location;
    }

    protected function checkBounds()
    {
        if ($this->radLat < self::$MIN_LAT || $this->radLat > self::$MAX_LAT ||
                $this->radLon < self::$MIN_LON || $this->radLon > self::$MAX_LON) {
            throw new \Exception('Invalid Argument');
        }
    }

    /**
     * Computes the great circle distance between this GeoLocation instance
     * and the location argument.
     *
     * @param  string  $unit_of_measurement
     *
     * @internal param float $radius the radius of the sphere, e.g. the average radius for a
     * spherical approximation of the figure of the Earth is approximately
     * 6371.01 kilometers.
     *
     * @return float the distance, measured in the same unit as the radius
     * argument.
     */
    public function distanceTo(GeoLocation $location, $unit_of_measurement)
    {
        $radius = $this->getEarthsRadius($unit_of_measurement);

        return acos(sin($this->radLat) * sin($location->radLat) +
                    cos($this->radLat) * cos($location->radLat) *
                    cos($this->radLon - $location->radLon)) * $radius;
    }

    /**
     * @return float the latitude, in degrees.
     */
    public function getLatitudeInDegrees()
    {
        return $this->degLat;
    }

    /**
     * @return float the longitude, in degrees.
     */
    public function getLongitudeInDegrees()
    {
        return $this->degLon;
    }

    /**
     * @return float the latitude, in radians.
     */
    public function getLatitudeInRadians()
    {
        return $this->radLat;
    }

    /**
     * @return float the longitude, in radians.
     */
    public function getLongitudeInRadians()
    {
        return $this->radLon;
    }

    /**
     * @return float angular radius.
     */
    public function getAngular()
    {
        return $this->angular;
    }

    public function __toString()
    {
        return '('.$this->degLat.', '.$this->degLon.') = ('.
                $this->radLat.' rad, '.$this->radLon.' rad';
    }

    /**
     * <p>Computes the bounding coordinates of all points on the surface
     * of a sphere that have a great circle distance to the point represented
     * by this GeoLocation instance that is less or equal to the distance
     * argument.</p>
     * <p>For more information about the formulae used in this method visit
     * <a href="http://JanMatuschek.de/LatitudeLongitudeBoundingCoordinates">
     * http://JanMatuschek.de/LatitudeLongitudeBoundingCoordinates</a>.</p>
     *
     * @param  float  $distance the distance from the point represented by this
     * GeoLocation instance. Must me measured in the same unit as the radius
     * argument.
     * @param  string  $unit_of_measurement
     * @return GeoLocation[] an array of two GeoLocation objects such that:<ul>
     * <li>The latitude of any point within the specified distance is greater
     * or equal to the latitude of the first array element and smaller or
     * equal to the latitude of the second array element.</li>
     * <li>If the longitude of the first array element is smaller or equal to
     * the longitude of the second element, then
     * the longitude of any point within the specified distance is greater
     * or equal to the longitude of the first array element and smaller or
     * equal to the longitude of the second array element.</li>
     * <li>If the longitude of the first array element is greater than the
     * longitude of the second element (this is the case if the 180th
     * meridian is within the distance), then
     * the longitude of any point within the specified distance is greater
     * or equal to the longitude of the first array element
     * <strong>or</strong> smaller or equal to the longitude of the second
     * array element.</li>
     * </ul>
     *
     * @throws \Exception
     *
     * @internal param radius the radius of the sphere, e.g. the average radius for a
     * spherical approximation of the figure of the Earth is approximately
     * 6371.01 kilometers.
     */
    public function boundingCoordinates($distance, $unit_of_measurement)
    {
        $radius = $this->getEarthsRadius($unit_of_measurement);
        if ($radius < 0 || $distance < 0) {
            throw new \Exception('Arguments must be greater than 0.');
        }

        // angular distance in radians on a great circle
        $this->angular = $distance / $radius;

        $minLat = $this->radLat - $this->angular;
        $maxLat = $this->radLat + $this->angular;

        $minLon = 0;
        $maxLon = 0;
        if ($minLat > self::$MIN_LAT && $maxLat < self::$MAX_LAT) {
            $deltaLon = asin(sin($this->angular) /
                cos($this->radLat));
            $minLon = $this->radLon - $deltaLon;
            if ($minLon < self::$MIN_LON) {
                $minLon += 2 * pi();
            }
            $maxLon = $this->radLon + $deltaLon;
            if ($maxLon > self::$MAX_LON) {
                $maxLon -= 2 * pi();
            }
        } else {
            // a pole is within the distance
            $minLat = max($minLat, self::$MIN_LAT);
            $maxLat = min($maxLat, self::$MAX_LAT);
            $minLon = self::$MIN_LON;
            $maxLon = self::$MAX_LON;
        }

        return [
            GeoLocation::fromRadians($minLat, $minLon),
            GeoLocation::fromRadians($maxLat, $maxLon),
        ];
    }

    protected function getEarthsRadius($unit_of_measurement)
    {
        $u = $unit_of_measurement;
        if ($u == 'miles' || $u == 'mi') {
            return $radius = self::EARTHS_RADIUS_MI;
        } elseif ($u == 'kilometers' || $u == 'km') {
            return $radius = self::EARTHS_RADIUS_KM;
        } else {
            throw new \Exception('You must supply a valid unit of measurement');
        }
    }

    /**
     *  Retrieves Geocoding information from Google
     *  eg. $response = GeoLocation::getGeocodeFromGoogle($location, $key);
     *		$latitude = $response->results[0]->geometry->location->lng;
     *	    $longitude = $response->results[0]->geometry->location->lng;
     *
     *	@param  string  $location address, city, state, etc.
     *	@param  string  $key - the key provided by Google
     *	@return \stdClass
     */
    public static function getGeocodeFromGoogle($location, $key = null)
    {
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($location).'&sensor=false&key='.$key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return json_decode(curl_exec($ch));
    }

    public static function MilesToKilometers($miles)
    {
        return $miles * 1.6093439999999999;
    }

    public static function KilometersToMiles($km)
    {
        return $km * 0.621371192237334;
    }
}
