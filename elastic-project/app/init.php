<?php

use Elasticsearch\ClientBuilder;

require 'vendor/autoload.php';

$es = ClientBuilder::create()
    ->setHosts(['localhost:9200'])
    ->build();

?>
