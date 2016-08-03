<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-3 上午9:32
 */

namespace Runner\DotEnv\Tests;

use Runner\DotEnv\DotEnv;

class DotEnvTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DotEnv
     */
    protected $dotenv;


    public function setUp()
    {
        $this->dotenv = new DotEnv();
    }


    public function testSetEnv()
    {
        $this->dotenv->setEnv('name', 'value');

        $this->assertSame('value', getenv('name'));
    }

}
