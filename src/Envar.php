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
     * @var string
     */
    protected $suffix = '.env';

    /**
     * @var array
     */
    private $environments = [];

    /**
     * @var array
     */
    protected $config = [];

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

        $this->config = $this->environments;
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

    /**
     * @param $name
     * @param $value
     * @return $this
     */
    public function set($name, $value)
    {
        $this->config[$name] = $value;

        return $this;
    }

    /**
     * @param $name
     * @return bool|mixed
     */
    public function get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : false;
    }
}