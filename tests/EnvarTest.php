<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace Tests;

use Runner\Envar\Envar;

class EnvarTest extends \PHPUnit_Framework_TestCase
{
    public function testSystemEnv()
    {
        $envar = new Envar(['LANG']);

        $this->assertEquals('zh_CN.UTF-8', $envar->get('LANG'));
    }

    public function testMixEnv()
    {
        $envar = new Envar(['LANG']);

        $this->assertEquals('zh_CN.UTF-8', $envar->get('LANG'));

        $envar->load(__DIR__ . '/envar.private');

        $this->assertEquals('gbk', $envar->get('LANG'));

        $this->assertTrue($envar->get('APP_DEBUG'));
        $this->assertEquals('true', $envar->get('APP_DEBUG_STRING'));
    }
}
