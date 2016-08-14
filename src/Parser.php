<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午9:20
 */

namespace Runner\Envar;

/**
 * Class Parser
 * @package Runner\Envar
 */
class Parser
{

    /**
     * @param string $filePath
     * @param bool $identification
     * @return array
     * @throws \Exception
     */
    public static function load($filePath, $identification = false)
    {
        if(!file_exists($filePath)) {
            throw new \Exception("{$filePath} is not exists");
        }

        $data = [];

        $file = new \SplFileObject($filePath);

        while(!$file->eof()) {
            if(
                (!$line = trim($file->fgets())) ||
                (false === $line = self::parseLine($line, $identification))
            ) {
                continue;
            }
            $data[$line[0]] = $line[1];
        }

        return $data;
    }


    /**
     * @param string $value
     * @return bool|float|int|null|string
     */
    public static function identifyDataType($value)
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


    /**
     * @param string $line
     * @param bool $identification
     * @return array|bool
     */
    public static function parseLine($line, $identification = false)
    {
        if('#' === substr($line, 0, 1)) {
            return false;
        }
        if(false === strpos($line, '=')) {
            return false;
        }
        list($name, $value) = array_map('trim', explode('=', $line, 2));

        if(0 === preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]{0,99}$/', $name)) {
            return false;
        }

        return [
            $name,
            ($identification ? self::identifyDataType($value) : $value),
        ];
    }
}