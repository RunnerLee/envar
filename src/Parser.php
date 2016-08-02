<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午9:20
 */

namespace Runner\DotEnv;

/**
 * Class Parser
 * @package Runner\DotEnv
 */
class Parser
{

    /**
     * @param string $filePath
     * @param bool $identification
     * @return array
     * @throws \Exception
     */
    public function load($filePath, $identification = false)
    {
        if(!file_exists($filePath)) {
            throw new \Exception("{$filePath} is not exists");
        }

        $data = [];

        $file = new \SplFileObject($filePath);

        while(!$file->eof()) {
            if(
                (!$line = trim($file->fgets())) ||
                (false === $line = $this->parseLine($line, $identification))
            ) {
                continue;
            }
            $data[$line[0]] = $line[1];
        }

        return $data;
    }


    /**
     * @param string $line
     * @param bool $identification
     * @return array|bool
     */
    public function parseLine($line, $identification = false)
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
            ($identification ? identifyDataType($value) : $value),
        ];
    }
}