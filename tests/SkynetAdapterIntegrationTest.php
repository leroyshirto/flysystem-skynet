<?php
namespace LeroyShirto\FlysystemSkynet\Test;

use League\Flysystem\Config;
use LeroyShirto\FlysystemSkynet\SkynetAdapter;
use LeroyShirto\FlysystemSkynet\SkynetClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class SkynetAdapterIntegrationTest extends TestCase
{

    protected $client;

    protected SkynetAdapter $skynetAdapter;

    public function setUp(): void
    {
        $this->client = new SkynetClient();

        $this->skynetAdapter = new SkynetAdapter($this->client, 'prefix');
    }

    /** @test */
    public function it_can_write()
    {
        $testFile = file_get_contents('https://siasky.net/vAGN_cv3KuPe7hpZEx67C-vcm6V6MWbJlzhZuT91pm4HHA');

        $result = $this->skynetAdapter->write('testUpload.txt', $testFile, new Config());

        die(print_r($result));
        $this->assertEquals(['sia://vAGN_cv3KuPe7hpZEx67C-vcm6V6MWbJlzhZuT91pm4HHA'], $result);
    }
}