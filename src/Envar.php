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
    /**
     * @var array
     */
    private $environments = [];

    /**
     * Envar constructor.
     *
     * @param array $environments
     */
    public function __construct(array $environments = [])
    {
        while (list(, $name) = each($environments)) {
            $this->environments[$name] = getenv($name);
        }
    }

    /**
     * @param $file
     * @return array
     */
    public function load($file)
    {
        return $this->loadFromArray((new Parser())->load($file), true);
    }

    /**
     * @param array $data
     * @param bool $overLoad
     * @return array
     */
    protected function loadFromArray(array $data, $overLoad = true)
    {
        $success = [];

        while(list($name, $value) = each($data)) {
            if($this->setEnv($name, $value, $overLoad)) {
                $success[$name] = $value;
                $this->environments[$name] = $value;
            }
        }

        return $success;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @param bool $overLoad
     * @return bool
     */
    protected function setEnv($name, $value, $overLoad = true)
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

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value)
    {
        $this->environments[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function get($name)
    {
        return isset($this->environments[$name]) ? $this->environments[$name] : false;
    }
}