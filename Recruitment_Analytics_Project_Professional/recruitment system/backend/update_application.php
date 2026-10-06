<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Composer autoloader
require 'db_config.php';
require 'mongodb_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $candidateId = $_POST['candidate_id'] ?? '';

    if ($candidateId) {
        $collection = getMongoDBCollection();
        if ($collection) {
            $objectId = new MongoDB\BSON\ObjectId($candidateId);

            if ($action === 'shortlist') {
                $updateResult = $collection->updateOne(
                    ['_id' => $objectId],
                    ['$set' => ['isShortlisted' => true, 'applicationStatus' => 'Shortlisted'],
                     '$push' => ['progressHistory' => ['status' => 'Shortlisted', 'timestamp' => new MongoDB\BSON\UTCDateTime()]]]
                );

                if ($updateResult->getModifiedCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Candidate shortlisted.']);
                    // In a real system, you'd trigger a notification here
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to shortlist candidate.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Candidate ID is required.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>