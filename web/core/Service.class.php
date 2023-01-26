<?php

namespace Core;

class Service {

    // Validate Inputs

    // Cleans string input
    protected function sanitizeString($string) {
        return trim(htmlspecialchars(strip_tags($string)));
    }

    // Checks if an input is empty
    protected function emptyInput($inputs) {
        // echo "<br>";
        // echo "<br>";
        // echo __METHOD__;
        // echo "<br>";

        // Iterate through each input
        foreach ($inputs as $key => $value) 
        {
//             echo "<br>";
//             var_dump($key);
//             echo "<br>";
//             var_dump($value);
            
            if (is_array($value)) 
            {   // If an array, do recursion
                if ($this->emptyInput($value)) {
                    return true;
                }
            }

            if (!is_int($value) && !$value)
            {   // If simple data and is empty, return true
                return true;
            }
        }

        // Returns false if all input has value
        return false;
    }

    protected function getResult(bool $query) {
        # code...
    }
}