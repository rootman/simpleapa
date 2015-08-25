<?php

use ApaiIO\ApaiIO;
use Mockery as m;
use Rootman\Simpleapa\SimpleAPA;

class SimpleAPATest extends PHPUnit_Framework_TestCase
{
    protected $apaiio;
    protected $apa;

    public function setUp()
    {
        $this->apaiio   = m::mock(ApaiIO::class);
        $this->apa      = new SimpleAPA($this->apaiio);
    }

    /** @test */
    public function it_runs_a_lookup()
    {
        $this->apaiio->shouldReceive('runOperation');

        $this->apa->bestPrice('testasin');
    }

}