<?php
require 'vendor/autoload.php'; // Assuming you installed the MongoDB PHP library via Composer

function connectMongoDB() {
    global $mongoHost;
    try {
        $client = new MongoDB\Client($mongoHost);
        return $client;
    } catch (MongoDB\Driver\Exception\Exception $e) {
        error_log("MongoDB connection failed: " . $e->getMessage());
        return null;
    }
}

function getMongoDBCollection() {
    global $mongoDbName, $mongoCollection;
    $client = connectMongoDB();
    if ($client) {
        return $client->selectDatabase($mongoDbName)->selectCollection($mongoCollection);
    }
    return null;
}
?>