<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 16-8-3 上午9:05
 */

namespace Tests;

use PHPUnit_Framework_TestCase;
use Runner\Envar\Parser;

class ParserTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    protected $parser;

    public function setUp()
    {
        $this->parser = new Parser();
    }

    public function testLineParser()
    {
        list(, $value) = $this->parser->parseLine('name=value');
        $this->assertEquals('value' , $value);
        list(, $value) = $this->parser->parseLine('bool=true', true);
        $this->assertEquals(true, $value);
        list(, $value) = $this->parser->parseLine('bool="true"', true);
        $this->assertEquals('true', $value);
        list(, $value) = $this->parser->parseLine('number=0.01', true);
        $this->assertSame(0.01, $value);
        list(, $value) = $this->parser->parseLine('number=100', true);
        $this->assertSame(100, $value);
    }


    public function testLoadFile()
    {
        $data = $this->parser->load(__DIR__ . '/.env');

        $this->assertEquals('true', $data['APP_DEBUG']);

        $data = $this->parser->load(__DIR__ . '/.env', true);

        $this->assertSame(true, $data['APP_DEBUG']);
    }
}
