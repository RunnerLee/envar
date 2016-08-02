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

        while($line = $file->fgets()) {
            if((!$line = trim($line)) || (false === $line = $this->parseLine($line, $identification))) {
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

        return [
            $name,
            ($identification ? identifyDataType($value) : $value),
        ];
    }
}