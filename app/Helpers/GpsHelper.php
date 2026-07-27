<?php

namespace App\Helpers;

class GpsHelper
{
    /**
     * Menghitung jarak antara dua koordinat GPS menggunakan Haversine formula.
     * 
     * @param float $lat1 Latitude titik pertama
     * @param float $lon1 Longitude titik pertama
     * @param float $lat2 Latitude titik kedua
     * @param float $lon2 Longitude titik kedua
     * @return float Jarak dalam meter
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Radius bumi dalam meter
        $earthRadius = 6371000;

        // Konversi derajat ke radian
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        // Selisih koordinat
        $deltaLat = $lat2Rad - $lat1Rad;
        $deltaLon = $lon2Rad - $lon1Rad;

        // Haversine formula
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($deltaLon / 2) * sin($deltaLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Jarak dalam meter
        $distance = $earthRadius * $c;

        return round($distance, 2);
    }

    /**
     * Validasi apakah koordinat GPS valid.
     * 
     * @param float $latitude
     * @param float $longitude
     * @return bool
     */
    public static function isValidCoordinates($latitude, $longitude)
    {
        // Validasi range latitude (-90 to 90)
        if ($latitude < -90 || $latitude > 90) {
            return false;
        }

        // Validasi range longitude (-180 to 180)
        if ($longitude < -180 || $longitude > 180) {
            return false;
        }

        return true;
    }

    /**
     * Cek apakah user berada dalam radius yang diizinkan.
     * 
     * @param float $userLat Latitude user
     * @param float $userLon Longitude user
     * @param float $targetLat Latitude target lokasi
     * @param float $targetLon Longitude target lokasi
     * @param int $radiusMeter Radius yang diizinkan dalam meter
     * @return array ['valid' => bool, 'distance' => float, 'message' => string]
     */
    public static function isWithinRadius($userLat, $userLon, $targetLat, $targetLon, $radiusMeter)
    {
        // Validasi koordinat
        if (!self::isValidCoordinates($userLat, $userLon)) {
            return [
                'valid' => false,
                'distance' => 0,
                'message' => 'Koordinat GPS user tidak valid'
            ];
        }

        if (!self::isValidCoordinates($targetLat, $targetLon)) {
            return [
                'valid' => false,
                'distance' => 0,
                'message' => 'Koordinat GPS lokasi kegiatan tidak valid'
            ];
        }

        // Hitung jarak
        $distance = self::calculateDistance($userLat, $userLon, $targetLat, $targetLon);

        // Cek apakah dalam radius
        $isValid = $distance <= $radiusMeter;

        $message = $isValid 
            ? "Anda berada dalam jangkauan lokasi kegiatan (jarak: {$distance}m)"
            : "Anda berada di luar jangkauan lokasi kegiatan (jarak: {$distance}m, maksimal: {$radiusMeter}m)";

        return [
            'valid' => $isValid,
            'distance' => $distance,
            'message' => $message
        ];
    }

    /**
     * Format koordinat untuk tampilan.
     * 
     * @param float $latitude
     * @param float $longitude
     * @return string
     */
    public static function formatCoordinates($latitude, $longitude)
    {
        if (empty($latitude) || empty($longitude)) {
            return 'Koordinat tidak tersedia';
        }

        return number_format($latitude, 6) . ', ' . number_format($longitude, 6);
    }

    /**
     * Generate Google Maps URL dari koordinat.
     * 
     * @param float $latitude
     * @param float $longitude
     * @param string $label Label untuk marker (optional)
     * @return string
     */
    public static function getGoogleMapsUrl($latitude, $longitude, $label = '')
    {
        if (empty($latitude) || empty($longitude)) {
            return '#';
        }

        $baseUrl = 'https://www.google.com/maps/search/';
        $query = $latitude . ',' . $longitude;
        
        if (!empty($label)) {
            $query = urlencode($label) . '/@' . $latitude . ',' . $longitude;
        }

        return $baseUrl . $query;
    }

    /**
     * Estimasi akurasi GPS berdasarkan jarak.
     * 
     * @param float $distance Jarak dalam meter
     * @return string
     */
    public static function getAccuracyLevel($distance)
    {
        if ($distance <= 5) {
            return 'Sangat Akurat';
        } elseif ($distance <= 10) {
            return 'Akurat';
        } elseif ($distance <= 25) {
            return 'Cukup Akurat';
        } elseif ($distance <= 50) {
            return 'Kurang Akurat';
        } else {
            return 'Tidak Akurat';
        }
    }

    /**
     * Konversi koordinat decimal degrees ke degrees, minutes, seconds.
     * 
     * @param float $decimal
     * @param string $type 'lat' atau 'lon'
     * @return string
     */
    public static function decimalToDMS($decimal, $type = 'lat')
    {
        $degrees = floor(abs($decimal));
        $minutes = floor((abs($decimal) - $degrees) * 60);
        $seconds = round(((abs($decimal) - $degrees) * 60 - $minutes) * 60, 2);

        $direction = '';
        if ($type === 'lat') {
            $direction = $decimal >= 0 ? 'N' : 'S';
        } else {
            $direction = $decimal >= 0 ? 'E' : 'W';
        }

        return $degrees . '° ' . $minutes . '\' ' . $seconds . '" ' . $direction;
    }
}
