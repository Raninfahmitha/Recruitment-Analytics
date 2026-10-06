<?php
header('Content-Type: application/json');
require 'vendor/autoload.php'; // Composer autoloader
require 'db_config.php';
require 'mongodb_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {
    $file = $_FILES['resume'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $fileTmpPath = $file['tmp_name'];
        $fileType = mime_content_type($fileTmpPath);
        $fileSize = $file['size'];

        // Basic file type and size validation
        $allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxSize) {
            // In a real application, you would parse the resume content here
            // For this example, we'll just store basic info
            $parsedText = "Resume uploaded: " . $fileName; // Text extraction can be added later

            $collection = getMongoDBCollection();
            if ($collection) {
                $insertResult = $collection->insertOne([
                    'candidateName' => $_POST['candidateName'] ?? 'Unknown',
                    'email' => $_POST['candidateEmail'] ?? '',
                    'jobRole' => $_POST['jobRole'] ?? 'Unspecified',
                    'source' => $_POST['source'] ?? 'Unknown',
                    'candidateName' => $_POST['candidateName'] ?? 'Unknown',
                    'email' => $_POST['candidateEmail'] ?? '',
                    'jobRole' => $_POST['jobRole'] ?? 'Unspecified',
                    'source' => $_POST['source'] ?? 'Unknown',
                    'originalResumeName' => $fileName,
                    'uploadDate' => new MongoDB\BSON\UTCDateTime(),
                    'resumeText' => $parsedText,
                    'applicationStatus' => 'Applied',
                    'isShortlisted' => false,
                    'progressHistory' => [['status' => 'Applied', 'timestamp' => new MongoDB\BSON\UTCDateTime()]]
                    // Add more fields based on your parsing logic
                ]);

                if ($insertResult->getInsertedCount() > 0) {
                    echo json_encode(['success' => true, 'message' => 'Resume uploaded successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to save resume information.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Database connection error.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type or size. Allowed types: PDF, DOC, DOCX (max 5MB).']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error during file upload.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>