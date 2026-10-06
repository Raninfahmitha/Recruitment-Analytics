<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Composer autoloader
require 'db_config.php';
require 'mongodb_helper.php';

$collection = getMongoDBCollection();

if ($collection) {
    $filter = [];
    if (isset($_GET['candidate_id'])) {
        $filter['_id'] = new MongoDB\BSON\ObjectId($_GET['candidate_id']);
    }

    $options = [];
    $cursor = $collection->find($filter, $options);
    $candidates = [];
    foreach ($cursor as $document) {
        // Convert MongoDB ObjectId to string for JSON serialization
        $document['_id'] = (string) $document['_id'];
        $candidates[] = $document;
    }

    if (isset($_GET['candidate_id']) && count($candidates) === 1) {
        echo json_encode(['success' => true, 'candidate' => $candidates[0]]);
    } else {
        echo json_encode(['success' => true, 'candidates' => $candidates]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Database connection error.']);
}
?>