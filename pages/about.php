<?php
$pageTitle = 'About Us - HOSTRUC';
$activePage = 'about';
require_once '../includes/header.php';
?>

<!-- =============================================
     ABOUT US SECTION
     ============================================= -->
<section class="au-section">
    <!-- decorative corners -->
    <div class="au-deco au-deco--tl"></div>
    <div class="au-deco au-deco--tr">
        <svg width="110" height="110" viewBox="0 0 110 110" fill="none">
            <polygon points="0,0 110,0 110,110" fill="#e07b2a" opacity="0.85"/>
            <polygon points="30,0 110,0 110,80" fill="#1a2f4a" opacity="0.85"/>
            <polygon points="60,0 110,0 110,50" fill="#0097a7" opacity="0.85"/>
        </svg>
    </div>
    <div class="au-deco au-deco--bl">
        <svg width="90" height="90" viewBox="0 0 90 90" fill="none">
            <polygon points="0,90 90,90 0,0" fill="#0097a7" opacity="0.75"/>
            <polygon points="0,90 60,90 0,30" fill="#1a2f4a" opacity="0.6"/>
        </svg>
    </div>

    <div class="au-inner">
        <div class="au-label-col">
            <h2 class="au-label">ABOUT US</h2>
        </div>
        <div class="au-text-col reveal-right">
            <p class="au-paragraph">
                <strong class="au-company-name">Holistika Strukturindo Konsultan</strong> is a consultancy firm specializing in building design and construction services with a comprehensive, solution-oriented approach. We believe that every structure should not only be strong and safe, but also an integral part of its surroundings, functionality, and the long-term vision of both its owners and users.
            </p>
            <p class="au-paragraph">
                Backed by a team of skilled and experienced professionals, we combine technical expertise with a deep understanding of our clients' needs and project context. We're not just designing buildings—we're creating value through efficient, sustainable, and forward-thinking structures. Our commitment is to deliver consultancy services that are not only technical, but also strategic—turning every project into a work that blends strength, aesthetics, and purposeful design.
            </p>
        </div>
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
     VISION & MISSION
     ============================================= -->
<section class="vm-section">
    <div class="vm-inner">
        <div class="vm-logo-col reveal-left">
            <div class="vm-logo-badge">
                <img src="<?= BASE ?>/assets/images/footerlogo.png" alt="HOSTRUC Logo" class="vm-logo-img">
                <div class="vm-logo-text">
                    <span>HOLISTIKA</span>
                    <span>STRUKTURINDO</span>
                    <span class="vm-logo-text-light">——— CONSULTANT ———</span>
                </div>
            </div>
        </div>
        <div class="vm-content-col reveal-right">
            <div class="vm-block">
                <h3 class="vm-heading"><span class="vm-heading-accent vm-accent-teal">VISION</span> <span class="vm-heading-label">HOSTRUC</span></h3>
                <p class="vm-text">
                    To become the leading design consultant known for our holistic approach, high-quality work, and integrity — inspiring trust and driving increased investment value in every project we handle.
                </p>
            </div>
            <div class="vm-block">
                <h3 class="vm-heading"><span class="vm-heading-accent vm-accent-orange">MISION</span> <span class="vm-heading-label">HOSTRUC</span></h3>
                <p class="vm-text">
                    <u>Hostruc</u> is committed to delivering design services that go beyond just solving technical, aesthetic, economic, environmental, and sustainability challenges — we aim to enhance the business appeal of our clients as well. Through a systematic and high-standard workflow, we position ourselves as a strategic partner for entrepreneurs, helping them develop properties that are not only functional, but also attractive to investors.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     MANAGEMENT & TEAM
     ============================================= -->
<section class="mgmt-section">
    <div class="mgmt-inner">
        <div class="mgmt-text-col reveal-left">
            <h2 class="mgmt-title">MANAGEMENT &amp; TEAM</h2>
            <p class="mgmt-text">
                Our team is specifically designed to deliver high-quality services to clients. Moreover, the team always strives to achieve minimal defect standards. In doing so, the team turns these achievements into added value for customers.
            </p>
            <p class="mgmt-text">
                In short, management commits to running good management and operational systems. This commitment enables the company to produce high-quality products, which in turn results in very competitive pricing in the market and enhances customer satisfaction.
            </p>
        </div>
        <div class="mgmt-method-col reveal-right">
            <div class="mgmt-method-box">
                <h3 class="mgmt-method-title">OUR INTEGRATED<br>METHODOLOGY</h3>
                <div class="mgmt-diagram">
                    <!-- Building icon center -->
                    <div class="diagram-center">
                        <svg width="72" height="72" viewBox="0 0 72 72" fill="none">
                            <rect x="16" y="28" width="40" height="36" rx="2" fill="#1a2f4a" opacity="0.85"/>
                            <polygon points="8,30 36,8 64,30" fill="#0097a7" opacity="0.85"/>
                            <rect x="28" y="44" width="16" height="20" fill="#fff" opacity="0.25"/>
                            <rect x="22" y="38" width="10" height="10" fill="#fff" opacity="0.3"/>
                            <rect x="40" y="38" width="10" height="10" fill="#fff" opacity="0.3"/>
                        </svg>
                    </div>
                    <!-- Role labels -->
                    <div class="diagram-label diagram-label--tl">
                        <div class="diagram-avatar">
                            <svg width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="11" r="7" fill="#0097a7" opacity="0.8"/><path d="M4 28 Q16 20 28 28" fill="#0097a7" opacity="0.6"/></svg>
                        </div>
                        <span>ARCHITECT</span>
                    </div>
                    <div class="diagram-label diagram-label--tr">
                        <div class="diagram-avatar">
                            <svg width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="11" r="7" fill="#1a2f4a" opacity="0.8"/><path d="M4 28 Q16 20 28 28" fill="#1a2f4a" opacity="0.6"/></svg>
                        </div>
                        <span>STRUCTURAL<br>ENGINEER</span>
                    </div>
                    <div class="diagram-label diagram-label--bl">
                        <div class="diagram-avatar">
                            <svg width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="11" r="7" fill="#e07b2a" opacity="0.8"/><path d="M4 28 Q16 20 28 28" fill="#e07b2a" opacity="0.6"/></svg>
                        </div>
                        <span>CLIENT</span>
                    </div>
                    <div class="diagram-label diagram-label--br">
                        <div class="diagram-avatar">
                            <svg width="32" height="32" viewBox="0 0 32 32"><circle cx="16" cy="11" r="7" fill="#4a7a9b" opacity="0.8"/><path d="M4 28 Q16 20 28 28" fill="#4a7a9b" opacity="0.6"/></svg>
                        </div>
                        <span>USER</span>
                    </div>
                </div>
                <ul class="mgmt-method-list">
                    <li>Collaborative Visioning</li>
                    <li>Client-Centric Design</li>
                    <li>Seamless Coordination</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     LEGAL DOCUMENTS
     ============================================= -->
<section class="legal-section reveal">
    <div class="legal-inner">
        <div class="legal-text-block">
            <p class="legal-desc">
                Our company's legal documents are available for partnership and procurement purposes. We provide official document copies upon request, including <strong>Deed of Establishment (Akta Pendirian)</strong>, <strong>Business Identification Number (NIB)</strong>, and <strong>Business Entity Certificate (SBU)</strong>. To obtain these documents, please send your request to our email.
            </p>
            <button class="legal-request-btn" id="legalToggleBtn">Request Legal Entity</button>
        </div>
        <div class="legal-docs-list">
            <div class="legal-doc-item">
                <i class="fas fa-file-alt"></i>
                <span>Akta Pendirian</span>
            </div>
            <div class="legal-doc-item">
                <i class="fas fa-id-card"></i>
                <span>NIB</span>
            </div>
            <div class="legal-doc-item">
                <i class="fas fa-certificate"></i>
                <span>SBU</span>
            </div>
        </div>
    </div>

    <!-- Request Form (collapsible) -->
    <div class="legal-form-wrap" id="legalFormWrap">
        <div class="legal-form-inner">
            <h3 class="legal-form-title">Request Legal Documents</h3>
            <form id="legalForm">
                <div class="legal-form-row">
                    <div class="legal-form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" required placeholder="Your Name">
                    </div>
                    <div class="legal-form-group">
                        <label>Email</label>
                        <input type="email" name="email" required placeholder="email@domain.com">
                    </div>
                </div>
                <div class="legal-form-group">
                    <label>Document Requested</label>
                    <select name="document" required>
                        <option value="">Select document</option>
                        <option value="Akta Pendirian">Deed of Establishment (Akta Pendirian)</option>
                        <option value="NIB">NIB (Nomor Induk Berusaha)</option>
                        <option value="SBU">SBU (Sertifikat Badan Usaha)</option>
                        <option value="Semua Dokumen">All Documents</option>
                    </select>
                </div>
                <div class="legal-form-group">
                    <label>Message (Optional)</label>
                    <textarea name="message" rows="3" placeholder="Purpose of document request..."></textarea>
                </div>
                <div class="legal-form-actions">
                    <button type="submit" class="legal-submit-btn">Send Request</button>
                    <button type="button" class="legal-cancel-btn" id="legalCancelBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
(function () {
    const toggleBtn  = document.getElementById('legalToggleBtn');
    const cancelBtn  = document.getElementById('legalCancelBtn');
    const formWrap   = document.getElementById('legalFormWrap');
    const legalForm  = document.getElementById('legalForm');

    function openForm() {
        formWrap.classList.add('active');
        formWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    function closeForm() {
        formWrap.classList.remove('active');
    }

    if (toggleBtn) toggleBtn.addEventListener('click', openForm);
    if (cancelBtn) cancelBtn.addEventListener('click', closeForm);

    if (legalForm) {
        legalForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const name     = this.name.value.trim();
            const email    = this.email.value.trim();
            const doc      = this.document.value;
            const message  = this.message.value.trim();

            const mailtoBody = encodeURIComponent(
                'Name: ' + name + '\n' +
                'Email: ' + email + '\n' +
                'Document: ' + doc + '\n' +
                (message ? 'Message: ' + message : '')
            );
            const mailtoLink = 'mailto:hostruc@gmail.com?subject=' +
                encodeURIComponent('Request Legal Entity - ' + doc) +
                '&body=' + mailtoBody;

            window.location.href = mailtoLink;
            this.reset();
            closeForm();
        });
    }
})();
</script>

<?php require_once '../includes/footer.php'; ?>
