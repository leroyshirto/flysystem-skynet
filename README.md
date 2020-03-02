# Flysystem adapter for Sia Skynet

This repository is not for production use.

It has been created as part of this hackathon https://github.com/NebulousLabs/Skynet-Hive/issues/1

This package contains a [Flysystem](https://flysystem.thephpleague.com/) adapter for Skynet

## Usage

By default this adapter is hardcoded to use the [https://skynet.tutemwesi.com](https://skynet.tutemwesi.com) Portal

``` php
use League\Flysystem\Filesystem;
use LeroyShirto\FlysystemSkynet\SkynetAdapter;
use LeroyShirto\FlysystemSkynet\SkynetClient;

$client = new SkynetClient();

$adapter = new SkynetAdapter($client);

$filesystem = new Filesystem($adapter);
```

## Testing

``` bash
$ composer test
```