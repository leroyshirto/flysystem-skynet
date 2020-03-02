<?php

namespace LeroyShirto\FlysystemSkynet;

use League\Flysystem\Adapter\AbstractAdapter;
use League\Flysystem\Adapter\Polyfill\NotSupportingVisibilityTrait;
use LeroyShirto\FlysystemSkynet\Exceptions\BadRequest;

class SkynetAdapter extends AbstractAdapter
{
    use NotSupportingVisibilityTrait;

    /** @var SkynetClient */
    protected SkynetClient $client;

    public function __construct(SkynetClient $client, string $prefix = '')
    {
        $this->client = $client;

        $this->setPathPrefix($prefix);
    }

    /**
     * @inheritDoc
     */
    public function write($path, $contents, \League\Flysystem\Config $config)
    {
        return $this->upload($path, $contents, 'add');
    }

    /**
     * @inheritDoc
     */
    public function writeStream($path, $resource, \League\Flysystem\Config $config)
    {
        // TODO: Implement writeStream() method.
    }

    /**
     * @inheritDoc
     */
    public function update($path, $contents, \League\Flysystem\Config $config)
    {
        // TODO: Implement update() method.
    }

    /**
     * @inheritDoc
     */
    public function updateStream($path, $resource, \League\Flysystem\Config $config)
    {
        // TODO: Implement updateStream() method.
    }

    /**
     * @inheritDoc
     */
    public function rename($path, $newpath)
    {
        // TODO: Implement rename() method.
    }

    /**
     * @inheritDoc
     */
    public function copy($path, $newpath)
    {
        // TODO: Implement copy() method.
    }

    /**
     * @inheritDoc
     */
    public function delete($path)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritDoc
     */
    public function deleteDir($dirname)
    {
        // TODO: Implement deleteDir() method.
    }

    /**
     * @inheritDoc
     */
    public function createDir($dirname, \League\Flysystem\Config $config)
    {
        // TODO: Implement createDir() method.
    }

    /**
     * @inheritDoc
     */
    public function setVisibility($path, $visibility)
    {
        // TODO: Implement setVisibility() method.
    }

    /**
     * @inheritDoc
     */
    public function has($path)
    {
        // TODO: Implement has() method.
    }

    /**
     * @inheritDoc
     */
    public function read($path)
    {
        // TODO: Implement read() method.
    }

    /**
     * @inheritDoc
     */
    public function readStream($path)
    {
        // TODO: Implement readStream() method.
    }

    /**
     * @inheritDoc
     */
    public function listContents($directory = '', $recursive = false)
    {
        // TODO: Implement listContents() method.
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($path)
    {
        // TODO: Implement getMetadata() method.
    }

    /**
     * @inheritDoc
     */
    public function getSize($path)
    {
        // TODO: Implement getSize() method.
    }

    /**
     * @inheritDoc
     */
    public function getMimetype($path)
    {
        // TODO: Implement getMimetype() method.
    }

    /**
     * @inheritDoc
     */
    public function getTimestamp($path)
    {
        // TODO: Implement getTimestamp() method.
    }

    /**
     * @inheritDoc
     */
    public function getVisibility($path)
    {
        // TODO: Implement getVisibility() method.
    }

    /**
     * @param string $path
     * @param resource|string $contents
     * @param string $mode
     *
     * @return array|false file metadata
     */
    protected function upload(string $path, $contents, string $mode): array
    {
        $path = $this->applyPathPrefix($path);

        try {
            $object = $this->client->upload($path, $contents, $mode);
        } catch (BadRequest $e) {
            return false;
        }

        return $object;
    }
}