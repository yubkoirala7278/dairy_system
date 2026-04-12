<?php

namespace App\Helpers;

class NumberHelper
{
    public static function toNepaliNumber($number)
    {
        // Format the number with commas and 2 decimal places
        $formattedNumber = number_format($number, 2, '.', ',');

        // Check if the number ends with .00 and remove the decimal part if so
        if (substr($formattedNumber, -3) == '.00') {
            $formattedNumber = substr($formattedNumber, 0, -3); // Remove .00
        }

        // Define English and Nepali numbers
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
        $nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९', '.'];

        // Replace English numbers with Nepali numbers
        return str_replace($englishNumbers, $nepaliNumbers, $formattedNumber);
    }

    public static function toEnglishNumber($number)
    {
        // Define Nepali and English numbers
        $nepaliNumbers = ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९', '.'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
    
        // Replace Nepali numbers with English numbers
        return str_replace($nepaliNumbers, $englishNumbers, $number);
    }
}

