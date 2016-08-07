<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-2 下午4:46
 */
namespace Runner\Envar;

/**
 * Class Envar
 *
 * @package Runner\Envar
 */
class Envar
{

    public function __construct()
    {
        if (!function_exists('putenv')) {
            throw new \Exception('function putenv has been disabled');
        }
    }

    /**
     * @param $file
     * @return array
     */
    public function loadFileConfigToSessionEnv($file)
    {
        return $this->loadArrayToSessionEnv(Parser::load($file), true);
    }


    public function loadArrayToSessionEnv(array $data, $overLoad = true)
    {
        while(list($name, $value) = each($data)) {
            if(!$this->setSessionEnvironment($name, $value, $overLoad)) {
                unset($data[$name]);
            }
        }

        return $data;
    }


    public function loadFileConfigToSystemEnv($file)
    {
        $data = Parser::load($file);

        
    }


    /**
     * @param string $name
     * @param mixed $value
     * @param bool $overLoad
     * @return bool
     */
    public function setSessionEnvironment($name, $value, $overLoad = true)
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