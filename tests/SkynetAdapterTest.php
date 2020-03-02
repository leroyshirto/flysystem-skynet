<?php
namespace LeroyShirto\FlysystemSkynet\Test;

use League\Flysystem\Config;
use LeroyShirto\FlysystemSkynet\SkynetAdapter;
use LeroyShirto\FlysystemSkynet\SkynetClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SkynetAdapterTest extends TestCase
{

    protected $client;

    protected SkynetAdapter $skynetAdapter;

    public function setUp(): void
    {
        $this->client = $this->prophesize(SkynetClient::class);

        $this->skynetAdapter = new SkynetAdapter($this->client->reveal(), 'prefix');
    }

    /** @test */
    public function it_can_write()
    {
        $this->client->upload(Argument::any(), Argument::any(), Argument::any())->willReturn(
            ['sia://vAGN_cv3KuPe7hpZEx67C-vcm6V6MWbJlzhZuT91pm4HHA']
        );

        $result = $this->skynetAdapter->write('something', 'contents', new Config());

        $this->assertEquals(['sia://vAGN_cv3KuPe7hpZEx67C-vcm6V6MWbJlzhZuT91pm4HHA'], $result);
    }
}