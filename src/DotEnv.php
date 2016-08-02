<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午4:46
 */
namespace Runner\DotEnv;

class DotEnv
{

    public function __construct()
    {
    }


    /**
     * @param array $data
     * @param bool $overLoad
     * @return array
     */
    public function loadFromArray(array $data, $overLoad = true)
    {
        $success = [];
        while(list($name, $value) = each($data)) {
            if($this->setEnv($name, $value, $overLoad)) {
                $success[$name] = $value;
            }
        }

        return $success;
    }


    /**
     * @param string $filePath
     * @param bool $overLoad
     * @return array
     */
    public function loadFromFile($filePath, $overLoad = true)
    {
        return $this->loadFromArray((new Parser())->load($filePath), $overLoad);
    }


    /**
     * @param string $name
     * @param mixed $value
     * @param bool $overLoad
     * @return bool
     */
    public function setEnv($name, $value, $overLoad = true)
    {
        if(!$overLoad) {
            switch (true) {
                case array_key_exists($name, $_ENV): return false;
                case array_key_exists($name, $_SERVER): return false;
                case false !== getenv($name): return false;
            }
        }

        function_exists('apache_setenv') && apache_setenv($name, $value);

        putenv("{$name}={$value}");

        $_ENV[$name] = $_SERVER[$name] = $value;

        return true;
    }

}