<?php
/* In this approach, we're assuming that the file data (name and path) is already coming from the frontend, and the file has been 
uploaded somewhere else already. This doesn't directly handle file uploads using PHP's $_FILES global variable, which is why it isn't 
handling actual file uploads.*/

/*require_once __DIR__ . '/../models/Attachment.php';

class AttachmentController {
    private $attachmentModel;

    public function __construct($pdo) {
        $this->attachmentModel = new Attachment($pdo);
    }

    // Adds a new attachment for a patient
    // Assumes file upload is already handled and path + name are passed to this controller
    public function add($data) {
        if (
            empty($data['patient_id']) ||
            empty($data['file_name']) ||
            empty($data['file_path'])
        ) {
            http_response_code(400);
            echo json_encode(['error' => 'All fields are required (patient_id, file_name, file_path).']);
            return;
        }

        $success = $this->attachmentModel->addAttachment(
            $data['patient_id'],
            $data['file_name'],
            $data['file_path']
        );

        echo json_encode(['success' => $success]);
    }

    // Returns all attachments of a patient
    public function getByPatient($patient_id) {
        $attachments = $this->attachmentModel->getAttachmentsByPatient($patient_id);
        echo json_encode($attachments);
    }

    public function getAll() {
        $attachments = $this->attachmentModel->getAllAttachments();
        echo json_encode($attachments);
    } */

// this version handles the actual file upload (by using $_FILES), moves the files to a permanent location, and then saves the file information in the database
/* kani na version kay mo handle na siya sa pag upload na buhaton sa back end, i check lang ( need ni siya ug multipart/form data didto sa html ba*/
require_once __DIR__ . '/../models/Attachment.php';

class AttachmentController {
    private $attachmentModel;

    public function __construct($pdo) {
        $this->attachmentModel = new Attachment($pdo);
    }

    // Adds a new attachment for a patient
    // Assumes file upload is already handled and path + name are passed to this controller
    public function add($data = null) {
        // Ensure patient_id and file are received
        $patient_id = $_POST['patient_id'];
        $file = $_FILES['attachment'];

        // Check if file was uploaded without error
        if (!$file || $file['error'] !== 0) {
            http_response_code(400);
            echo json_encode(['error' => 'File upload failed.']);
            return;
        }

        // Define the directory for storing uploaded files
        $uploadDir = __DIR__ . '/../uploads/';
        $fileName = basename($file['name']);
        $filePath = $uploadDir . $fileName;

        // Move the file to the upload directory
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            http_response_code(500);
            echo json_encode(['error' => 'Could not move uploaded file.']);
            return;
        }

        // Save the file data to the database
        $success = $this->attachmentModel->addAttachment(
            $patient_id,
            $fileName,
            '/uploads/' . $fileName
        );

        // Return success response
        echo json_encode(['success' => $success]);
    }

    // Returns all attachments of a patient
    public function getByPatient($patient_id) {
        $attachments = $this->attachmentModel->getAttachmentsByPatient($patient_id);
        echo json_encode($attachments);
    }

    // Returns all attachments (if needed sa design, gi include nalang nako)
    public function getAll() {
        $attachments = $this->attachmentModel->getAllAttachments();
        echo json_encode($attachments);
    }
}


