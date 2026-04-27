<?php
// Handle legal document request form
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $document = $_POST['document'] ?? '';
    $message = $_POST['message'] ?? '';
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($document)) {
        echo json_encode(['success' => false, 'message' => 'Field required tidak boleh kosong']);
        exit;
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Email tidak valid']);
        exit;
    }
    
    // Prepare email content
    $subject = "Request Document: " . $document;
    $emailContent = "
Telah menerima request dokumen legal dari:\n\n
Nama: " . htmlspecialchars($name) . "\n
Email: " . htmlspecialchars($email) . "\n
Dokumen: " . htmlspecialchars($document) . "\n
Pesan: " . htmlspecialchars($message) . "\n\n
Silakan hubungi pihak yang bersangkutan melalui email atau telepon.
    ";
    
    // Email addresses
    $toEmail = "halo@hostruc.com";
    $replyToEmail = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : "noreply@hostruc.com";
    
    // Send email
    $headers = "From: " . $replyToEmail . "\r\n";
    $headers .= "Reply-To: " . $replyToEmail . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    if (mail($toEmail, $subject, $emailContent, $headers)) {
        // Also send confirmation to user
        $userSubject = "Konfirmasi Request Dokumen - HOSTRUC";
        $userMessage = "
Terima kasih telah mengirim request dokumen. Kami telah menerima permintaan Anda untuk dokumen:\n\n
Dokumen: " . htmlspecialchars($document) . "\n
Kami akan meninjau request Anda dan menghubungi Anda dalam 1-2 hari kerja.\n\n
Best regards,\n
Tim HOSTRUC
        ";
        
        $userHeaders = "From: halo@hostruc.com\r\n";
        $userHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        mail($email, $userSubject, $userMessage, $userHeaders);
        
        echo json_encode(['success' => true, 'message' => 'Request berhasil dikirim']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal mengirim request, silakan coba lagi']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
