<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午11:01
 */

if(!function_exists('identifyDataType')) {
    function identifyDataType($value)
    {
        if(is_numeric($value)) {
            if(false !== strpos($value, '.')) {
                return floatval($value);
            }
            return intval($value);
        }
        switch (strtolower($value)) {
            case 'false': return false;
            case 'true': return true;
            case 'null': return null;
        }

        if(
            (('"' === $temp = substr($value, 0, 1)) || "'" === $temp) &&
            $temp === substr($value, -1)
        ) {
            if(in_array($temp = strtolower(substr($value, 1, -1)), ['false', 'true', 'null'])) {
                return $temp;
            }
        }

        return $value;
    }
}

if(!function_exists('envar')) {
    function envar($name, $default = '')
    {
        if(false === $value = getenv($name)) {
            return $default;
        }
        return identifyDataType($value);
    }
}