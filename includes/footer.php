<?php
$_fn = $settings ?? [];
$_co_name    = setting($_fn, 'company_name',    'CV. Holistika Strukturindo Konsultant');
$_co_tagline = setting($_fn, 'company_tagline', 'Holistic Approach to Building Design');
$_co_email   = setting($_fn, 'company_email',   'hostruc@gmail.com');
$_co_ig      = setting($_fn, 'instagram',       'https://www.instagram.com/hostruc_consulting');
$_co_wa      = setting($_fn, 'whatsapp',        '6285846110978');
$_co_addr    = setting($_fn, 'address',         'Wisma Jaya Jalan Kusuma Utara III Blok 5 Nomor 15, Durenjaya, Bekasi Timur, Kota Bekasi');
$_co_ph1     = setting($_fn, 'phone_triono',    '0856-9378-5271');
$_co_ph2     = setting($_fn, 'phone_farhan',    '0858-4611-0978');
$_co_akta    = setting($_fn, 'akta_no',         'No. 23, 21 August 2025');
$_co_year    = date('Y');
?>
<!-- FOOTER -->
<footer class="footer">
    <div class="footer-main">
        <div class="footer-grid">

            <!-- Col 1: Brand -->
            <div class="footer-brand">
                <img src="<?= BASE ?>/assets/images/logo.jpeg" alt="HOSTRUC Logo" class="footer-brand-logo">
                <p class="footer-brand-name"><?= strtoupper($_co_name) ?></p>
                <p class="footer-brand-tagline"><?= $_co_tagline ?></p>
                <div class="footer-socials">
                    <a href="<?= $_co_ig ?>" target="_blank" class="footer-social-icon" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/<?= $_co_wa ?>" target="_blank" class="footer-social-icon" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:<?= $_co_email ?>" class="footer-social-icon" aria-label="Email">
                        <i class="fa fa-envelope"></i>
                    </a>
                </div>
            </div>

            <!-- Col 2: Quick Links -->
            <div class="footer-col">
                <h4 class="footer-col-title">Quick Links</h4>
                <ul class="footer-col-list">
                    <li><a href="<?= BASE ?>/index.php">Home</a></li>
                    <li><a href="<?= BASE ?>/pages/about.php">About Us</a></li>
                    <li><a href="<?= BASE ?>/pages/services.php">Services</a></li>
                    <li><a href="<?= BASE ?>/pages/projects.php">Projects</a></li>
                    <li><a href="<?= BASE ?>/pages/career.php">Career</a></li>
                    <li><a href="<?= BASE ?>/pages/contact.php">Contact</a></li>
                </ul>
            </div>

            <!-- Col 3: Our Services -->
            <div class="footer-col">
                <h4 class="footer-col-title">Our Services</h4>
                <ul class="footer-col-list">
                    <li><a href="<?= BASE ?>/pages/services.php">Architectural Design</a></li>
                    <li><a href="<?= BASE ?>/pages/services.php">Structural Design</a></li>
                    <li><a href="<?= BASE ?>/pages/services.php">MEP</a></li>
                    <li><a href="<?= BASE ?>/pages/services.php">Project Management</a></li>
                    <li><a href="<?= BASE ?>/pages/services.php">Value Engineering</a></li>
                </ul>
            </div>

            <!-- Col 4: Contact -->
            <div class="footer-col">
                <h4 class="footer-col-title">Contact</h4>
                <ul class="footer-contact-list">
                    <li>
                        <i class="fa fa-map-marker-alt"></i>
                        <span><?= $_co_addr ?></span>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        <span><?= $_co_ph1 ?> (Triono)<br><?= $_co_ph2 ?> (Farhan)</span>
                    </li>
                    <li>
                        <i class="fa fa-envelope"></i>
                        <a href="mailto:<?= $_co_email ?>"><?= $_co_email ?></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <p>© <?= $_co_year ?> <?= $_co_name ?>. All Rights Reserved. | Deed of Establishment: <?= $_co_akta ?></p>
    </div>
</footer>

<script src="<?= BASE ?>/assets/js/main.js"></script>
</body>
</html>
