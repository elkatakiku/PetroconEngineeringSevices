<?php

namespace Core;

class Service {

    // Validate Inputs

    // Cleans string input
    protected function sanitizeString($string): string
    {
        return trim(htmlspecialchars(strip_tags($string)));
    }

    // Checks if an input is empty
    protected function emptyInput($inputs): bool
    {
        // Iterate through each input
        foreach ($inputs as $key => $value) 
        {

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
}