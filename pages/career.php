<?php
$pageTitle = 'Career - HOSTRUC';
$activePage = 'career';
require_once '../includes/header.php';

// Load open positions from DB
$positions = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM career_positions WHERE active=1 ORDER BY sort_order, id");
    if ($res) {
        while ($row = $res->fetch_assoc()) $positions[] = $row;
    }
}
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero">
    <div class="hero-text-block">
        <h1 class="hero-title">Join Our<br>Team</h1>
    </div>
    <div class="hero-image-wrap">
        <img src="<?= BASE ?>/assets/images/career.png" alt="Career at HOSTRUC" loading="eager">
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
     WHAT IS IT LIKE TO WORK AT HOSTRUC?
     ============================================= -->
<section class="ww-section">
    <div class="ww-inner">
        <h2 class="ww-heading reveal">WHAT IS IT LIKE TO WORK AT HOSTRUC?</h2>
        <div class="ww-grid reveal">

            <div class="ww-card">
                <div class="ww-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="ww-card-title">Company's Culture</h3>
                <p class="ww-card-desc">Each member is expected to provide the best service to customers, work in unity, respect one another, and only give the best of their potentials in delivering their work.</p>
            </div>

            <div class="ww-card">
                <div class="ww-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3 class="ww-card-title">Respect Each Other</h3>
                <p class="ww-card-desc">We develop solid teamwork, respect each other and are open to give advice that build positive traits and focus on clear and achievable goals.</p>
            </div>

            <div class="ww-card">
                <div class="ww-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="ww-card-title">Teamwork</h3>
                <p class="ww-card-desc">"United we stand, divided we fall". Ability to work together towards a common vision and mission, having a strong ability to direct and encourage individuals to achieve and reach organizational goals together. Through strong teamwork, we can achieve big achievements that we may never have thought of before.</p>
            </div>

            <div class="ww-card">
                <div class="ww-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <h3 class="ww-card-title">Comfortable and Effective Work Atmosphere</h3>
                <p class="ww-card-desc">The level of employee happiness can be directly proportional to their work-related productivity. So it is good to keep the company atmosphere conducive. We create a balance between work and home.</p>
            </div>

        </div>
    </div>
</section>

<!-- =============================================
     OPEN POSITIONS
     ============================================= -->
<section class="career-pos-section">
    <div class="career-pos-inner">
        <h2 class="career-pos-heading reveal">Open Positions</h2>
        <div class="career-pos-grid reveal">

            <?php if (!empty($positions)): foreach ($positions as $pos):
                $hasDetails = !empty($pos['job_desc']) || !empty($pos['requirements']);
                $applySubj  = urlencode('Application - ' . $pos['title']);
                $applyEmail = setting($settings, 'company_email', 'hostruc@gmail.com');
                $jobLines   = $pos['job_desc']      ? array_filter(array_map('trim', preg_split('/\r?\n/', $pos['job_desc']))) : [];
                $reqLines   = $pos['requirements']  ? array_filter(array_map('trim', preg_split('/\r?\n/', $pos['requirements']))) : [];
            ?>
            <div class="career-pos-card<?= $hasDetails ? ' career-pos-card--full' : '' ?>">
                <div class="career-pos-top">
                    <h3 class="career-pos-title"><?= htmlspecialchars($pos['title']) ?></h3>
                    <?php if (!empty($pos['location'])): ?>
                    <span class="career-pos-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($pos['location']) ?></span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($pos['description']) && !$hasDetails): ?>
                <p class="career-pos-desc"><?= htmlspecialchars($pos['description']) ?></p>
                <?php endif; ?>
                <?php if ($hasDetails): ?>
                <div class="career-pos-details">
                    <?php if (!empty($jobLines)): ?>
                    <p class="career-detail-label">Job Descriptions:</p>
                    <ol class="career-detail-list">
                        <?php foreach ($jobLines as $line): ?>
                        <li><?= htmlspecialchars(preg_replace('/^\d+\.\s*/', '', $line)) ?></li>
                        <?php endforeach; ?>
                    </ol>
                    <?php endif; ?>
                    <?php if (!empty($reqLines)): ?>
                    <p class="career-detail-label">Requirements:</p>
                    <ol class="career-detail-list">
                        <?php foreach ($reqLines as $line): ?>
                        <li><?= htmlspecialchars(preg_replace('/^\d+\.\s*/', '', $line)) ?></li>
                        <?php endforeach; ?>
                    </ol>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <a href="mailto:<?= htmlspecialchars($applyEmail) ?>?subject=<?= $applySubj ?>" class="career-apply-btn">Apply Now</a>
            </div>
            <?php endforeach; else: ?>

            <!-- Fallback if DB is empty -->
            <div class="career-pos-card">
                <div class="career-pos-top">
                    <h3 class="career-pos-title">Arsitek Senior</h3>
                    <span class="career-pos-location"><i class="fas fa-map-marker-alt"></i> Jakarta</span>
                </div>
                <p class="career-pos-desc">We are looking for an experienced senior architect with a minimum of 8 years in commercial and residential building design.</p>
                <a href="mailto:hostruc@gmail.com?subject=Application%20-%20Arsitek%20Senior" class="career-apply-btn">Apply Now</a>
            </div>
            <div class="career-pos-card">
                <div class="career-pos-top">
                    <h3 class="career-pos-title">Structural Engineer</h3>
                    <span class="career-pos-location"><i class="fas fa-map-marker-alt"></i> Jakarta / Surabaya</span>
                </div>
                <p class="career-pos-desc">Experienced structural engineer for design and structural calculations across various building types.</p>
                <a href="mailto:hostruc@gmail.com?subject=Application%20-%20Structural%20Engineer" class="career-apply-btn">Apply Now</a>
            </div>
            <div class="career-pos-card">
                <div class="career-pos-top">
                    <h3 class="career-pos-title">Junior Architect</h3>
                    <span class="career-pos-location"><i class="fas fa-map-marker-alt"></i> Jakarta</span>
                </div>
                <p class="career-pos-desc">Fresh graduate in Architecture to join our design team and learn from experienced professionals.</p>
                <a href="mailto:hostruc@gmail.com?subject=Application%20-%20Junior%20Architect" class="career-apply-btn">Apply Now</a>
            </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<!-- =============================================
     APPLICATION PROCESS
     ============================================= -->
<section class="career-proc-section reveal">
    <div class="career-proc-inner">
        <h2 class="career-proc-heading">Application Process</h2>
        <div class="career-proc-body">
            <div class="career-proc-docs">
                <p class="career-proc-intro">To apply, please prepare the following documents:</p>
                <ul class="career-proc-list">
                    <li>Complete Curriculum Vitae (CV)</li>
                    <li>Motivation letter</li>
                    <li>Portfolio / best works (for design positions)</li>
                    <li>Copies of educational certificates and transcripts</li>
                    <li>Letter of recommendation (if available)</li>
                </ul>
            </div>
            <div class="career-proc-contact">
                <p class="career-proc-send">Send your application to:</p>
                <?php $careerEmail = setting($settings, 'company_email', 'hostruc@gmail.com'); ?>
                <a href="mailto:<?= $careerEmail ?>" class="career-proc-email"><?= $careerEmail ?></a>
                <p class="career-proc-subject">Subject format: <strong>[Position Applied For] – Your Name</strong></p>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
