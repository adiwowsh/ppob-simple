<?php

function containsWord($string, $words){
    // Convert the string to lowercase for case-insensitive comparison
    $lowercaseString = strtolower($string);

    if (is_array($words)) {
        // Check if any of the selected words exist in the string
        foreach ($words as $word) {
            $lowercaseWord = strtolower($word);
            if (strpos($lowercaseString, $lowercaseWord) !== false) {
                return true;
            }
        }
    } else {
        // Check if the specific word exists in the string
        $lowercaseWord = strtolower($words);
        if (strpos($lowercaseString, $lowercaseWord) !== false OR strpos($lowercaseWord, $lowercaseString) !== false) {
            return true;
        }
    }

    return false;

}
