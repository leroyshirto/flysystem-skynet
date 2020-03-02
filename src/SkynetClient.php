<?php


namespace LeroyShirto\FlysystemSkynet;

use Exception;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class SkynetClient
{

    const MAX_CHUNK_SIZE = 1024 * 1024 * 150;

    const UPLOAD_SESSION_START = 0;
    const UPLOAD_SESSION_APPEND = 1;

    const PORTAL_URL = 'https://skynet.tutemwesi.com';
    const PORTAL_UPLOAD_PATH = 'skynet/skyfile';
    const PORTAL_FILE_FIELD_NAME = 'file';
    const CUSTOM_FILE_NAME = '';

    /** @var \GuzzleHttp\Client */
    protected $client;

    /** @var int */
    protected $maxChunkSize;

    /** @var int */
    protected $maxUploadChunkRetries;

    protected $uploadUrl;

    /**
     * @param GuzzleClient|null $client
     * @param int $maxChunkSize Set max chunk size per request (determines when to switch from "one shot upload" to upload session and defines chunk size for uploads via session).
     * @param int $maxUploadChunkRetries How many times to retry an upload session start or append after RequestException.
     */
    public function __construct(GuzzleClient $client = null, int $maxChunkSize = self::MAX_CHUNK_SIZE, int $maxUploadChunkRetries = 0)
    {
        $this->client = $client ?? new GuzzleClient(['handler' => GuzzleFactory::handler()]);

        $this->maxChunkSize = ($maxChunkSize < self::MAX_CHUNK_SIZE ? ($maxChunkSize > 1 ? $maxChunkSize : 1) : self::MAX_CHUNK_SIZE);
        $this->maxUploadChunkRetries = $maxUploadChunkRetries;

        // TODO: This should come from config
        $this->uploadUrl = self::PORTAL_URL . "/" . self::PORTAL_UPLOAD_PATH;
    }

    public function upload(string $path, $contents, $mode = 'add'): array
    {
        $response = $this->uploadFile($path, $contents);

        $metadata = json_decode($response->getBody(), true);

        return $metadata;
    }

    /**
     * @param string $path
     * @param string|resource|StreamInterface $body
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws Exception
     */
    public function uploadFile(string $path, $body = ''): ResponseInterface
    {
        try {
            $uuid = $this->generateRandomString();
            $response = $this->client->request(
                'POST',$this->uploadUrl . '/' . $uuid, [
                'multipart' => [
                    [
                        'name'     => self::PORTAL_FILE_FIELD_NAME,
                        'contents' => $body,
                        'filename' => $path
                    ]
                ]
            ]);
        } catch (Exception $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * @param string $path
     * @return ResponseInterface
     * @throws Exception
     */
    public function downloadFile(string $path)
    {
        try {
            $response = $this->client->get(self::PORTAL_URL . '/' . $path);
        } catch (Exception $exception) {
            throw $exception;
        }

        return $response;
    }

    function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}