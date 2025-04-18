<?php
require_once __DIR__ . '/../models/Attachment.php';

class AttachmentController
{
    private $attachmentModel;

    public function __construct()
    {
        $this->attachmentModel = new Attachment();
    }

    // Adds a new attachment for a patient
    // Assumes file upload is already handled and path + name are passed to this controller
    public function add($data)
    {
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
    public function getByPatient($patient_id)
    {
        $attachments = $this->attachmentModel->getAttachmentsByPatient($patient_id);
        echo json_encode($attachments);
    }
}
