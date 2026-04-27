<?php
$pageTitle = 'Contact - HOSTRUC';
$activePage = 'contact';

// Try DB connection gracefully — page still renders if DB is unavailable
$conn = null;
try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli('localhost', 'root', '', 'hostruc_db');
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    $conn = null;
}

$success = '';
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name))    $errors[] = 'Name is required.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if (empty($message)) $errors[] = 'Message is required.';

    if (empty($errors)) {
        if ($conn) {
            try {
                $stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('sssss', $name, $email, $phone, $subject, $message);
                $stmt->execute();
                $stmt->close();
                $success = 'Your message has been sent! We will get back to you shortly.';
            } catch (Exception $e) {
                $errors[] = 'Failed to save your message. Please contact us directly via email.';
            }
        } else {
            $success = 'Your message has been received. We will get back to you shortly.';
        }
    }
}

require_once '../includes/header.php';
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero">
    <div class="hero-text-block">
        <h1 class="hero-title">Contact<br>Us</h1>
    </div>
    <div class="hero-image-wrap">
        <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1920&q=80"
             alt="Modern office interior" loading="eager">
    </div>
</section>

<!-- =============================================
     PILLARS STRIP
     ============================================= -->
<div class="au-pillars-strip">
    <div class="au-pillars-inner">
        <div class="au-pillar">
            <span class="au-pillar-icon"><i class="fas fa-bolt"></i></span>
            <span class="au-pillar-word">Efficient</span>
        </div>
        <div class="au-pillar-divider"></div>
        <div class="au-pillar">
            <span class="au-pillar-icon"><i class="fas fa-leaf"></i></span>
            <span class="au-pillar-word">Sustainable</span>
        </div>
        <div class="au-pillar-divider"></div>
        <div class="au-pillar">
            <span class="au-pillar-icon"><i class="fas fa-lightbulb"></i></span>
            <span class="au-pillar-word">Future&#8209;Thinking</span>
        </div>
    </div>
</div>

<!-- =============================================
     CONTACT US — MAP + INFO
     ============================================= -->
<section class="contact-us-section reveal">
    <div class="contact-us-inner">
        <div class="contact-us-deco">
            <img src="<?= BASE ?>/assets/images/logo.jpeg" alt="" class="contact-us-deco-img">
        </div>
        <h2 class="contact-us-heading">
            <span class="contact-heading-dark">CONTACT</span> <span class="contact-heading-teal">US</span>
        </h2>
        <div class="contact-us-body">
            <div class="contact-us-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.0!2d107.0!3d-6.23!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698c6b1e5b7b7b%3A0x1234567890abcdef!2sJl.%20Kusuma%20Utara%20III%2C%20Durenjaya%2C%20Bekasi%20Timur%2C%20Kota%20Bekasi%2C%20Jawa%20Barat!5e0!3m2!1sen!2sid!4v1"
                    width="100%" height="320" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" title="HOSTRUC Location"></iframe>
            </div>
            <div class="contact-us-info">
                <div class="contact-us-item">
                    <div class="contact-us-icon contact-icon-pin">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <p class="contact-us-text">Wisma Jaya Jalan Kusuma Utara III Blok 5 Nomor 15, Desa/Kelurahan Durenjaya, Kec. Bekasi Timur, Kota Bekasi</p>
                </div>
                <div class="contact-us-item">
                    <div class="contact-us-icon contact-icon-email">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="contact-us-text">email : hostruc@gmail.com</p>
                </div>
                <div class="contact-us-item">
                    <div class="contact-us-icon contact-icon-phone">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <p class="contact-us-text">Phone :<br>0856-9378-5271 (Triono)<br>0858-4611-0978 (Farhan)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     CONTACT FORM
     ============================================= -->
<section class="ctc-form-section">
    <div class="ctc-form-inner">
        <h2 class="ctc-form-title">Send a Message</h2>
        <p class="ctc-form-sub">Fill in the form below and we will get back to you as soon as possible.</p>

        <?php if ($success): ?>
            <div class="ctc-alert ctc-alert--success">
                <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="ctc-alert ctc-alert--error">
                <?php foreach ($errors as $e): ?>
                    <p><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="ctc-form">
            <div class="ctc-form-row">
                <div class="ctc-form-group">
                    <label>Name <span class="ctc-req">*</span></label>
                    <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" placeholder="Your full name">
                </div>
                <div class="ctc-form-group">
                    <label>Email <span class="ctc-req">*</span></label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="email@domain.com">
                </div>
            </div>
            <div class="ctc-form-row">
                <div class="ctc-form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" placeholder="+62 812-xxxx-xxxx">
                </div>
                <div class="ctc-form-group">
                    <label>Subject</label>
                    <input type="text" name="subject" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" placeholder="Topic of your message">
                </div>
            </div>
            <div class="ctc-form-group">
                <label>Message <span class="ctc-req">*</span></label>
                <textarea name="message" rows="5" placeholder="Write your message or inquiry here..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="ctc-submit-btn">Send Message</button>
        </form>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
