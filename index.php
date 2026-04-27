<?php
$pageTitle = 'HOSTRUC - Holistic Approach to Building Design';
$activePage = 'home';
require_once 'includes/header.php';

// Services for offer slider
$offerServices = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM services ORDER BY sort_order, id");
    if ($res) while ($row = $res->fetch_assoc()) $offerServices[] = $row;
}

// Hero slides from DB, fall back to local images
$heroSlides = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM hero_slides WHERE active=1 ORDER BY sort_order");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $heroSlides[] = ['src' => $row['image_url'], 'alt' => $row['title'] ?? 'HOSTRUC'];
        }
    }
}
if (empty($heroSlides)) {
    foreach ([['hero.png','HOSTRUC Building'],['career.png','HOSTRUC Team']] as [$f,$a]) {
        if (file_exists(__DIR__ . '/assets/images/' . $f)) {
            $heroSlides[] = ['src' => BASE . '/assets/images/' . $f, 'alt' => $a];
        }
    }
}
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero">
    <!-- Title above image -->
    <div class="hero-text-block">
        <h1 class="hero-title"><?= settingRaw($settings, 'hero_title', 'Building Value Through<br>Holistic Vision') ?></h1>
    </div>

    <!-- Hero Image Slider -->
    <div class="hero-image-wrap">
        <div class="hero-slider" id="heroSlider">
            <?php foreach ($heroSlides as $i => $slide): ?>
            <div class="hero-slide<?= $i === 0 ? ' active' : '' ?>">
                <img src="<?= htmlspecialchars($slide['src']) ?>"
                     alt="<?= htmlspecialchars($slide['alt']) ?>"
                     loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Arrows -->
        <button class="hero-arrow hero-arrow--prev" id="heroPrev" aria-label="Previous slide">&#8249;</button>
        <button class="hero-arrow hero-arrow--next" id="heroNext" aria-label="Next slide">&#8250;</button>

        <!-- Dots -->
        <div class="hero-dots" id="heroDots">
            <?php foreach ($heroSlides as $i => $slide): ?>
            <button class="hero-dot<?= $i === 0 ? ' active' : '' ?>" data-index="<?= $i ?>" aria-label="Slide <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
(function () {
    const slides   = document.querySelectorAll('.hero-slide');
    const dots     = document.querySelectorAll('.hero-dot');
    const prevBtn  = document.getElementById('heroPrev');
    const nextBtn  = document.getElementById('heroNext');
    if (!slides.length) return;

    let current = 0;
    let timer;

    function goTo(index) {
        slides[current].classList.remove('active');
        dots[current]?.classList.remove('active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current]?.classList.add('active');
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function startAuto() {
        timer = setInterval(next, 5000);
    }

    function resetAuto() {
        clearInterval(timer);
        startAuto();
    }

    prevBtn?.addEventListener('click', () => { prev(); resetAuto(); });
    nextBtn?.addEventListener('click', () => { next(); resetAuto(); });
    dots.forEach(dot => dot.addEventListener('click', () => {
        goTo(+dot.dataset.index);
        resetAuto();
    }));

    // Pause on hover
    const wrap = document.querySelector('.hero-image-wrap');
    wrap?.addEventListener('mouseenter', () => clearInterval(timer));
    wrap?.addEventListener('mouseleave', startAuto);

    startAuto();
})();
</script>

<!-- =============================================
     INTRO STRIP
     ============================================= -->
<div class="intro-strip">
    <div class="intro-inner reveal">
        <div class="intro-content">
            <p class="intro-company">Holistika Strukturindo Consultant (HOSTRUC)</p>
            <p class="intro-tagline">A comprehensive, solution-oriented architectural and engineering consultancy.</p>
        </div>
        <a href="<?= BASE ?>/pages/about.php" class="intro-arrow" title="About Us">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M3.5 9H14.5M14.5 9L9.5 4M14.5 9L9.5 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </div>
</div>

<!-- =============================================
     EXPERTISE — COMPREHENSIVE SOLUTION
     ============================================= -->
<section class="expertise-section">
    <div class="expertise-inner">
        <!-- Left: text -->
        <div class="expertise-left reveal-left">
            <h2 class="expertise-title">Comprehensive,<br>Solution-Oriented<br>Expertise</h2>
            <ul class="expertise-list">
                <li>Specialists in Building Design &amp; Construction Services</li>
                <li>Skilled Team of Experienced Professionals</li>
                <li>Combining Technical Expertise with Deep Client Understanding</li>
            </ul>
        </div>
        <!-- Right: floor plan -->
        <div class="expertise-right reveal-right">
            <div class="floorplan-box">
                <img src="<?= BASE ?>/assets/images/GAMBAR COMPREHENSIF SOLUTION.png" alt="Comprehensive Solution">
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     EVERY STRUCTURE BANNER
     ============================================= -->
<div class="structure-banner-wrapper">
<section class="structure-banner">
    <div class="structure-banner-bg"></div>
    <div class="structure-banner-content reveal">
        <h2 class="structure-label">Every Structure<br>An Integral Part</h2>
        <p class="structure-sub">Fostering long-term vision, functionality, and seamless surrounding integration.</p>
    </div>
</section>
</div>

<!-- =============================================
     EFFICIENT / SUSTAINABLE / FUTURE-THINKING
     ============================================= -->
<section class="sustainable-section">
    <div class="sustainable-inner">
        <div class="sustainable-left reveal-left">
            <h2 class="sustainable-headline">Efficient,<br>Sustainable,<br>Future&#8209;Thinking</h2>
        </div>
        <div class="sustainable-right reveal-right">
            <div class="sustain-items">
                <div class="sustain-item">
                    <div class="sustain-icon-box" style="background:#e8f5e9;border-color:#a5d6a7;">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M16 4 C8 4 5 12 8 18 C10 22 14 24 16 28 C18 24 22 22 24 18 C27 12 24 4 16 4 Z" fill="#4caf50" opacity="0.8"/>
                            <path d="M10 16 Q16 10 22 16" stroke="#2e7d32" stroke-width="1.5" fill="none"/>
                        </svg>
                    </div>
                    <div class="sustain-item-text">
                        <p class="sustain-item-title">Eco-conscious design philosophy</p>
                        <p class="sustain-item-desc">LEED/BREEAM standards, low-carbon materials, and biophilic design in every project.</p>
                    </div>
                </div>
                <div class="sustain-item">
                    <div class="sustain-icon-box" style="background:#e3f2fd;border-color:#90caf9;">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <rect x="4" y="8" width="24" height="14" rx="2" fill="#ffd54f" stroke="#f9a825" stroke-width="1.2"/>
                            <line x1="12" y1="8" x2="12" y2="22" stroke="#f9a825" stroke-width="1"/>
                            <line x1="20" y1="8" x2="20" y2="22" stroke="#f9a825" stroke-width="1"/>
                            <line x1="4" y1="15" x2="28" y2="15" stroke="#f9a825" stroke-width="1"/>
                            <line x1="16" y1="22" x2="16" y2="27" stroke="#9e9e9e" stroke-width="1.5"/>
                            <line x1="10" y1="27" x2="22" y2="27" stroke="#9e9e9e" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <div class="sustain-item-text">
                        <p class="sustain-item-title">Strategic, purposeful architecture</p>
                        <p class="sustain-item-desc">Renewable energy integration and building lifecycle analysis.</p>
                    </div>
                </div>
                <div class="sustain-item">
                    <div class="sustain-icon-box" style="background:#e0f7fa;border-color:#80deea;">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M16 4 Q22 12 22 19 C22 24 19.3 27 16 27 C12.7 27 10 24 10 19 Q10 12 16 4 Z" fill="#4fc3f7" opacity="0.85"/>
                            <path d="M13 20 Q15 17 18 19" stroke="#0288d1" stroke-width="1.2" fill="none"/>
                        </svg>
                    </div>
                    <div class="sustain-item-text">
                        <p class="sustain-item-title">Full-lifecycle commitment</p>
                        <p class="sustain-item-desc">Water efficiency, waste reduction, and post-occupancy monitoring.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =============================================
     WHAT SETS US APART
     ============================================= -->
<section class="apart-section">
    <div class="apart-inner">
        <div class="apart-layout">

            <!-- Quote top -->
            <div class="apart-quote-col reveal">
                <p class="apart-title">
                    What sets us apart from the rest is our visionary goal &amp; truly holistic designs that are specially curated to perfection for our clients.
                </p>
            </div>

            <!-- 4 Cards below -->
            <div class="apart-cards-col reveal">
                <div class="categories-grid">

                    <!-- Commercial -->
                    <div class="category-card">
                        <div class="category-icon">
                            <svg width="72" height="60" viewBox="0 0 72 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="8" y="16" width="56" height="36" fill="none" stroke="#1a2030" stroke-width="1.3"/>
                                <line x1="8" y1="28" x2="64" y2="28" stroke="#1a2030" stroke-width="0.9" opacity="0.55"/>
                                <line x1="8" y1="40" x2="64" y2="40" stroke="#1a2030" stroke-width="0.9" opacity="0.55"/>
                                <line x1="24" y1="16" x2="24" y2="52" stroke="#1a2030" stroke-width="0.9" opacity="0.55"/>
                                <line x1="40" y1="16" x2="40" y2="52" stroke="#1a2030" stroke-width="0.9" opacity="0.55"/>
                                <rect x="12" y="19" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="28" y="19" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="44" y="19" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="12" y="31" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="28" y="31" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="44" y="31" width="8" height="7" fill="none" stroke="#1a2030" stroke-width="0.8"/>
                                <rect x="30" y="43" width="12" height="9" fill="none" stroke="#1a2030" stroke-width="0.9"/>
                                <line x1="4" y1="16" x2="68" y2="16" stroke="#1a2030" stroke-width="1.5"/>
                                <line x1="2" y1="52" x2="70" y2="52" stroke="#1a2030" stroke-width="1.1"/>
                            </svg>
                        </div>
                        <h3 class="category-title">Commercial</h3>
                        <p class="category-description">Commercial properties, office buildings, shopping centers, commercial establishments, hotels, and warehouses</p>
                    </div>

                    <!-- Residential -->
                    <div class="category-card">
                        <div class="category-icon">
                            <svg width="72" height="60" viewBox="0 0 72 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="12" y="22" width="48" height="30" fill="none" stroke="#1a2030" stroke-width="1.3"/>
                                <polyline points="8,22 36,6 64,22" fill="none" stroke="#1a2030" stroke-width="1.3"/>
                                <line x1="36" y1="6" x2="36" y2="22" stroke="#1a2030" stroke-width="0.8" opacity="0.5" stroke-dasharray="3 2"/>
                                <path d="M29,52 L29,38 Q29,32 36,32 Q43,32 43,38 L43,52" fill="none" stroke="#1a2030" stroke-width="1.1"/>
                                <circle cx="41" cy="43" r="1.2" fill="#1a2030"/>
                                <rect x="15" y="28" width="10" height="9" fill="none" stroke="#1a2030" stroke-width="0.9"/>
                                <line x1="20" y1="28" x2="20" y2="37" stroke="#1a2030" stroke-width="0.7"/>
                                <line x1="15" y1="32.5" x2="25" y2="32.5" stroke="#1a2030" stroke-width="0.7"/>
                                <rect x="47" y="28" width="10" height="9" fill="none" stroke="#1a2030" stroke-width="0.9"/>
                                <line x1="52" y1="28" x2="52" y2="37" stroke="#1a2030" stroke-width="0.7"/>
                                <line x1="47" y1="32.5" x2="57" y2="32.5" stroke="#1a2030" stroke-width="0.7"/>
                                <line x1="2" y1="52" x2="70" y2="52" stroke="#1a2030" stroke-width="1.1"/>
                                <rect x="48" y="8" width="5" height="10" fill="none" stroke="#1a2030" stroke-width="0.9"/>
                            </svg>
                        </div>
                        <h3 class="category-title">Residential</h3>
                        <p class="category-description">Single-family homes, apartments, residential complexes, and housing developments for families</p>
                    </div>

                    <!-- Hospitality -->
                    <div class="category-card">
                        <div class="category-icon">
                            <svg width="72" height="60" viewBox="0 0 72 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line x1="2" y1="52" x2="70" y2="52" stroke="#4ecdc4" stroke-width="1.1"/>
                                <path d="M6,52 Q10,28 22,18 Q32,10 44,14 Q56,18 64,32 Q68,42 66,52" fill="none" stroke="#4ecdc4" stroke-width="1.4"/>
                                <path d="M14,52 Q17,34 26,24 Q34,16 46,20 Q56,24 60,38 Q62,46 60,52" fill="none" stroke="#4ecdc4" stroke-width="0.9" opacity="0.6"/>
                                <path d="M10,44 Q30,38 60,44" fill="none" stroke="#4ecdc4" stroke-width="0.85" opacity="0.65"/>
                                <path d="M8,36 Q28,28 62,36" fill="none" stroke="#4ecdc4" stroke-width="0.85" opacity="0.65"/>
                                <path d="M9,28 Q26,20 60,28" fill="none" stroke="#4ecdc4" stroke-width="0.85" opacity="0.55"/>
                                <circle cx="22" cy="40" r="1.8" fill="#4ecdc4" opacity="0.7"/>
                                <circle cx="32" cy="36" r="1.8" fill="#4ecdc4" opacity="0.7"/>
                                <circle cx="42" cy="34" r="1.8" fill="#4ecdc4" opacity="0.7"/>
                                <circle cx="52" cy="36" r="1.8" fill="#4ecdc4" opacity="0.7"/>
                                <ellipse cx="36" cy="52" rx="20" ry="3" fill="none" stroke="#4ecdc4" stroke-width="0.8" opacity="0.5"/>
                            </svg>
                        </div>
                        <h3 class="category-title category-title--teal">Hospitality</h3>
                        <p class="category-description">Sports stadiums, nightclubs, resorts, and world-class entertainment facilities</p>
                    </div>

                    <!-- Multipurpose -->
                    <div class="category-card">
                        <div class="category-icon">
                            <svg width="72" height="60" viewBox="0 0 72 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line x1="2" y1="52" x2="70" y2="52" stroke="#e07b2a" stroke-width="1.1"/>
                                <rect x="4" y="30" width="36" height="22" fill="none" stroke="#e07b2a" stroke-width="1.3"/>
                                <path d="M4,30 Q22,18 40,30" fill="none" stroke="#e07b2a" stroke-width="1.3"/>
                                <rect x="42" y="18" width="26" height="34" fill="none" stroke="#e07b2a" stroke-width="1.3"/>
                                <rect x="46" y="22" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="57" y="22" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="46" y="32" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="57" y="32" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="46" y="42" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="57" y="42" width="7" height="6" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <rect x="14" y="40" width="14" height="12" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                                <line x1="56" y1="6" x2="56" y2="18" stroke="#e07b2a" stroke-width="1.2"/>
                                <line x1="42" y1="8" x2="64" y2="8" stroke="#e07b2a" stroke-width="1.2"/>
                                <rect x="24" y="18" width="5" height="12" fill="none" stroke="#e07b2a" stroke-width="0.9"/>
                            </svg>
                        </div>
                        <h3 class="category-title category-title--orange">Multipurpose</h3>
                        <p class="category-description">Manufacturing plants, mining facilities, automotive, food processing, and warehouse complexes</p>
                    </div>

                </div><!-- /.categories-grid -->
            </div><!-- /.apart-cards-col -->

        </div><!-- /.apart-layout -->
    </div><!-- /.apart-inner -->
</section>

<!-- =============================================
     OUR SERVICES — WHAT WE CAN OFFER
     ============================================= -->
<section class="offer-section">

    <!-- Header -->
    <div class="offer-header reveal">
        <p class="offer-eyebrow">Our Services</p>
        <h2 class="offer-heading">What We Can Offer</h2>
    </div>

    <!-- Slider wrapper -->
    <div class="offer-slider-wrap">
        <!-- Prev arrow -->
        <button class="offer-arrow offer-arrow--prev" id="offerPrev" aria-label="Previous">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M13 4L7 10L13 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <!-- Track -->
        <div class="offer-track" id="offerTrack">

            <?php foreach ($offerServices as $svc): ?>
            <div class="offer-card">
                <div class="offer-card-img">
                    <?php if (!empty($svc['image'])): ?>
                        <img src="<?= htmlspecialchars($svc['image']) ?>"
                             alt="<?= htmlspecialchars($svc['title']) ?>"
                             loading="lazy">
                    <?php else: ?>
                        <div class="offer-card-placeholder">
                            <i class="fas <?= htmlspecialchars($svc['icon'] ?? 'fa-drafting-compass') ?>"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="offer-card-label"><?= htmlspecialchars($svc['title']) ?></div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($offerServices)): ?>
            <!-- Fallback cards if DB is empty -->
            <!-- Card 1: Construction -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--1">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <!-- Blueprint desk background -->
                        <rect width="400" height="480" fill="#b8a89a"/>
                        <rect width="400" height="480" fill="#8b7355" opacity="0.3"/>
                        <!-- Blueprint paper -->
                        <rect x="20" y="60" width="300" height="220" fill="#1a3a5c" opacity="0.85" rx="2"/>
                        <!-- Blueprint grid -->
                        <?php for($i=0;$i<16;$i++): ?>
                        <line x1="20" y1="<?=60+$i*14?>" x2="320" y2="<?=60+$i*14?>" stroke="#4a7aab" stroke-width="0.4" opacity="0.5"/>
                        <?php endfor; ?>
                        <?php for($i=0;$i<22;$i++): ?>
                        <line x1="<?=20+$i*14?>" y1="60" x2="<?=20+$i*14?>" y2="280" stroke="#4a7aab" stroke-width="0.4" opacity="0.5"/>
                        <?php endfor; ?>
                        <!-- Floor plan drawing -->
                        <rect x="50" y="90" width="240" height="160" fill="none" stroke="#7ab8f5" stroke-width="1.8"/>
                        <line x1="50" y1="145" x2="290" y2="145" stroke="#7ab8f5" stroke-width="1.4"/>
                        <line x1="170" y1="90" x2="170" y2="250" stroke="#7ab8f5" stroke-width="1.4"/>
                        <rect x="70" y="100" width="30" height="38" fill="none" stroke="#a0c8f0" stroke-width="1"/>
                        <rect x="180" y="100" width="90" height="38" fill="none" stroke="#a0c8f0" stroke-width="1"/>
                        <path d="M80,250 Q80,240 90,240" fill="none" stroke="#a0c8f0" stroke-width="1.2"/>
                        <!-- Yellow hard hat -->
                        <ellipse cx="310" cy="340" rx="55" ry="38" fill="#f5c842"/>
                        <ellipse cx="310" cy="325" rx="42" ry="28" fill="#f5c842"/>
                        <rect x="270" y="340" width="80" height="8" rx="4" fill="#e6b800"/>
                        <!-- Pencil/ruler -->
                        <rect x="60" y="290" width="180" height="12" rx="3" fill="#d4a853" transform="rotate(-15 60 290)"/>
                        <polygon points="60,290 55,302 66,298" fill="#c8a030" transform="rotate(-15 60 290)"/>
                        <!-- Rolled blueprints -->
                        <ellipse cx="340" cy="200" rx="18" ry="40" fill="#1a3a5c" opacity="0.9"/>
                        <ellipse cx="340" cy="200" rx="14" ry="37" fill="#2a5a8c" opacity="0.7"/>
                        <line x1="340" y1="160" x2="340" y2="240" stroke="#4a7aab" stroke-width="1"/>
                        <!-- Tape measure -->
                        <rect x="330" y="370" width="50" height="50" rx="8" fill="#f0a030"/>
                        <circle cx="355" cy="395" r="14" fill="#d08020"/>
                        <circle cx="355" cy="395" r="6" fill="#f0a030"/>
                        <!-- Overlay gradient bottom -->
                        <rect width="400" height="480" fill="url(#grad1)"/>
                        <defs>
                            <linearGradient id="grad1" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="offer-card-label">Construction</div>
            </div>

            <!-- Card 2: Commercial Interior -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--2">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="grad2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                            <linearGradient id="ceiling2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#d8e4ec"/>
                                <stop offset="100%" stop-color="#c0cfdb"/>
                            </linearGradient>
                            <linearGradient id="floor2" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#d0ccc4"/>
                                <stop offset="100%" stop-color="#b8b0a4"/>
                            </linearGradient>
                        </defs>
                        <!-- Room background -->
                        <rect width="400" height="480" fill="#e8eef2"/>
                        <!-- Ceiling -->
                        <rect width="400" height="80" fill="url(#ceiling2)"/>
                        <!-- Floor -->
                        <rect y="380" width="400" height="100" fill="url(#floor2)"/>
                        <!-- Back wall -->
                        <rect y="80" width="400" height="300" fill="#edf1f4"/>
                        <!-- Ceiling grid lights -->
                        <?php for($i=0;$i<5;$i++): ?>
                        <rect x="<?=20+$i*76?>" y="72" width="56" height="8" rx="1" fill="#fff" opacity="0.9"/>
                        <rect x="<?=30+$i*76?>" y="70" width="36" height="3" rx="1" fill="#fffde0" opacity="0.8"/>
                        <?php endfor; ?>
                        <!-- Light glow on floor -->
                        <?php for($i=0;$i<5;$i++): ?>
                        <ellipse cx="<?=48+$i*76?>" cy="370" rx="30" ry="5" fill="#fff8e0" opacity="0.5"/>
                        <?php endfor; ?>
                        <!-- Perspective floor lines -->
                        <?php for($i=1;$i<8;$i++): ?>
                        <line x1="0" y1="<?=380+$i*12?>" x2="400" y2="<?=380+$i*12?>" stroke="#c4bfb6" stroke-width="0.6"/>
                        <?php endfor; ?>
                        <!-- Chairs row 1 -->
                        <?php for($i=0;$i<4;$i++): ?>
                        <!-- Chair seat -->
                        <rect x="<?=30+$i*90?>" y="290" width="60" height="40" rx="3" fill="#c8cdd4"/>
                        <!-- Chair back -->
                        <rect x="<?=33+$i*90?>" y="250" width="54" height="44" rx="3" fill="#b8bdc4"/>
                        <!-- Chair legs -->
                        <line x1="<?=38+$i*90?>" y1="330" x2="<?=34+$i*90?>" y2="360" stroke="#9a9fa6" stroke-width="3"/>
                        <line x1="<?=82+$i*90?>" y1="330" x2="<?=86+$i*90?>" y2="360" stroke="#9a9fa6" stroke-width="3"/>
                        <!-- Desk -->
                        <rect x="<?=22+$i*90?>" y="288" width="76" height="6" rx="1" fill="#a8906a"/>
                        <?php endfor; ?>
                        <!-- Chairs row 2 (further back, smaller) -->
                        <?php for($i=0;$i<4;$i++): ?>
                        <rect x="<?=35+$i*90?>" y="210" width="46" height="30" rx="2" fill="#b8bdc4" opacity="0.8"/>
                        <rect x="<?=37+$i*90?>" y="185" width="42" height="28" rx="2" fill="#a8adb4" opacity="0.8"/>
                        <rect x="<?=27+$i*90?>" y="208" width="62" height="5" rx="1" fill="#987850" opacity="0.8"/>
                        <?php endfor; ?>
                        <!-- Back chairs (smallest) -->
                        <?php for($i=0;$i<5;$i++): ?>
                        <rect x="<?=20+$i*74?>" y="150" width="36" height="22" rx="2" fill="#a0a5ac" opacity="0.6"/>
                        <rect x="<?=22+$i*74?>" y="132" width="32" height="20" rx="2" fill="#909599" opacity="0.6"/>
                        <?php endfor; ?>
                        <!-- Overlay -->
                        <rect width="400" height="480" fill="url(#grad2)"/>
                    </svg>
                </div>
                <div class="offer-card-label">Commercial Interior &ndash;<br>Furniture Fitting Out</div>
            </div>

            <!-- Card 3: MEP -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--3">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="grad3" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                        </defs>
                        <!-- Warm background -->
                        <rect width="400" height="480" fill="#d4c4b0"/>
                        <rect width="400" height="480" fill="#c8a882" opacity="0.4"/>
                        <!-- Hands drawing/measuring — abstract -->
                        <!-- Table surface -->
                        <rect y="280" width="400" height="200" fill="#b89870"/>
                        <rect y="278" width="400" height="6" fill="#a08060"/>
                        <!-- Blueprint sheet on table -->
                        <rect x="30" y="220" width="280" height="200" fill="#1a3560" opacity="0.9" rx="2"/>
                        <!-- Blueprint lines -->
                        <?php for($i=0;$i<10;$i++): ?>
                        <line x1="30" y1="<?=230+$i*18?>" x2="310" y2="<?=230+$i*18?>" stroke="#4a80c0" stroke-width="0.5" opacity="0.6"/>
                        <?php endfor; ?>
                        <?php for($i=0;$i<18;$i++): ?>
                        <line x1="<?=30+$i*16?>" y1="220" x2="<?=30+$i*16?>" y2="420" stroke="#4a80c0" stroke-width="0.5" opacity="0.6"/>
                        <?php endfor; ?>
                        <!-- Schematic drawing on blueprint -->
                        <!-- Pipe layout -->
                        <line x1="60" y1="260" x2="280" y2="260" stroke="#7ab8f5" stroke-width="2.5"/>
                        <line x1="120" y1="260" x2="120" y2="340" stroke="#7ab8f5" stroke-width="2"/>
                        <line x1="200" y1="260" x2="200" y2="340" stroke="#7ab8f5" stroke-width="2"/>
                        <circle cx="120" cy="260" r="5" fill="#a0d0f8"/>
                        <circle cx="200" cy="260" r="5" fill="#a0d0f8"/>
                        <!-- Electrical symbols -->
                        <circle cx="80" cy="310" r="8" fill="none" stroke="#f5d020" stroke-width="1.5"/>
                        <line x1="72" y1="310" x2="88" y2="310" stroke="#f5d020" stroke-width="1.2"/>
                        <line x1="80" y1="302" x2="80" y2="318" stroke="#f5d020" stroke-width="1.2"/>
                        <circle cx="160" cy="310" r="8" fill="none" stroke="#f5d020" stroke-width="1.5"/>
                        <line x1="152" y1="310" x2="168" y2="310" stroke="#f5d020" stroke-width="1.2"/>
                        <line x1="160" y1="302" x2="160" y2="318" stroke="#f5d020" stroke-width="1.2"/>
                        <!-- Compass/ruler tool -->
                        <line x1="260" y1="200" x2="300" y2="380" stroke="#d0c0a0" stroke-width="3" stroke-linecap="round"/>
                        <line x1="260" y1="200" x2="220" y2="380" stroke="#d0c0a0" stroke-width="3" stroke-linecap="round"/>
                        <circle cx="260" cy="200" r="6" fill="#b8a080"/>
                        <line x1="230" y1="330" x2="290" y2="330" stroke="#c0b090" stroke-width="1.5"/>
                        <!-- Hand silhouette (abstract) -->
                        <ellipse cx="200" cy="420" rx="60" ry="30" fill="#c8a882" opacity="0.8"/>
                        <rect x="155" y="390" width="18" height="50" rx="8" fill="#c8a882" opacity="0.9"/>
                        <rect x="177" y="380" width="16" height="55" rx="8" fill="#c8a882" opacity="0.9"/>
                        <rect x="197" y="382" width="16" height="53" rx="8" fill="#c8a882" opacity="0.9"/>
                        <rect x="217" y="388" width="14" height="47" rx="7" fill="#c8a882" opacity="0.9"/>
                        <rect x="234" y="398" width="12" height="38" rx="6" fill="#c8a882" opacity="0.9"/>
                        <!-- Overlay -->
                        <rect width="400" height="480" fill="url(#grad3)"/>
                    </svg>
                </div>
                <div class="offer-card-label">Mechanical Electrical &ndash; Plumbing &ndash;<br>Data &amp; Voice Works</div>
            </div>

            <!-- Card 4: Structural Engineering -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--4">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="grad4" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                            <linearGradient id="skyGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#b0c8d8"/>
                                <stop offset="100%" stop-color="#8aaabb"/>
                            </linearGradient>
                        </defs>
                        <rect width="400" height="480" fill="url(#skyGrad)"/>
                        <!-- Steel structure -->
                        <!-- Main columns -->
                        <rect x="60" y="80" width="20" height="380" fill="#4a5568"/>
                        <rect x="320" y="80" width="20" height="380" fill="#4a5568"/>
                        <!-- Cross beams -->
                        <?php for($i=0;$i<6;$i++): ?>
                        <rect x="60" y="<?=80+$i*60?>" width="280" height="14" fill="#5a6678"/>
                        <!-- Diagonal bracing -->
                        <line x1="80" y1="<?=94+$i*60?>" x2="320" y2="<?=94+($i+1)*60?>" stroke="#6a7888" stroke-width="5"/>
                        <line x1="320" y1="<?=94+$i*60?>" x2="80" y2="<?=94+($i+1)*60?>" stroke="#6a7888" stroke-width="5"/>
                        <?php endfor; ?>
                        <!-- Secondary columns -->
                        <rect x="190" y="80" width="12" height="380" fill="#4a5568"/>
                        <!-- Bolts/connections -->
                        <?php for($i=0;$i<7;$i++): ?>
                        <circle cx="70" cy="<?=87+$i*60?>" r="5" fill="#8a9aaa"/>
                        <circle cx="325" cy="<?=87+$i*60?>" r="5" fill="#8a9aaa"/>
                        <circle cx="196" cy="<?=87+$i*60?>" r="5" fill="#8a9aaa"/>
                        <?php endfor; ?>
                        <!-- Ground -->
                        <rect y="440" width="400" height="40" fill="#3a4050"/>
                        <!-- Overlay -->
                        <rect width="400" height="480" fill="url(#grad4)"/>
                    </svg>
                </div>
                <div class="offer-card-label">Structural Engineering &amp; Analysis</div>
            </div>

            <!-- Card 5: Sustainability -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--5">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="grad5" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                            <linearGradient id="greenSky" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#a8d8b0"/>
                                <stop offset="100%" stop-color="#78b888"/>
                            </linearGradient>
                        </defs>
                        <rect width="400" height="480" fill="url(#greenSky)"/>
                        <!-- Green building -->
                        <rect x="80" y="140" width="240" height="300" fill="#3a6048" opacity="0.9"/>
                        <!-- Balcony greenery per floor -->
                        <?php for($i=0;$i<6;$i++): ?>
                        <!-- Floor slab -->
                        <rect x="70" y="<?=160+$i*46?>" width="260" height="8" fill="#2a4838"/>
                        <!-- Windows -->
                        <?php for($j=0;$j<4;$j++): ?>
                        <rect x="<?=90+$j*54?>" y="<?=170+$i*46?>" width="36" height="28" rx="2" fill="#a8d4c8" opacity="0.7"/>
                        <?php endfor; ?>
                        <!-- Green balcony plants -->
                        <ellipse cx="<?=110?>" cy="<?=163+$i*46?>" rx="18" ry="9" fill="#5a9060"/>
                        <ellipse cx="<?=200?>" cy="<?=163+$i*46?>" rx="22" ry="9" fill="#4a8050"/>
                        <ellipse cx="<?=290?>" cy="<?=163+$i*46?>" rx="18" ry="9" fill="#5a9060"/>
                        <?php endfor; ?>
                        <!-- Rooftop solar -->
                        <?php for($i=0;$i<3;$i++): ?>
                        <rect x="<?=100+$i*66?>" y="134" width="52" height="28" rx="2" fill="#f0d060" opacity="0.85"/>
                        <line x1="<?=126+$i*66?>" y1="134" x2="<?=126+$i*66?>" y2="162" stroke="#d0a820" stroke-width="1"/>
                        <line x1="<?=100+$i*66?>" y1="148" x2="<?=152+$i*66?>" y2="148" stroke="#d0a820" stroke-width="1"/>
                        <?php endfor; ?>
                        <!-- Trees around -->
                        <ellipse cx="40" cy="340" rx="28" ry="36" fill="#4a8040"/>
                        <rect x="36" y="370" width="8" height="60" fill="#5a3020"/>
                        <ellipse cx="360" cy="320" rx="26" ry="34" fill="#5a9050"/>
                        <rect x="356" y="348" width="8" height="72" fill="#5a3020"/>
                        <!-- Ground -->
                        <rect y="430" width="400" height="50" fill="#3a5030"/>
                        <!-- Overlay -->
                        <rect width="400" height="480" fill="url(#grad5)"/>
                    </svg>
                </div>
                <div class="offer-card-label">Sustainability &amp; Green Building Consulting</div>
            </div>

            <!-- Card 6: Project Management -->
            <div class="offer-card">
                <div class="offer-card-img offer-card-img--6">
                    <svg viewBox="0 0 400 480" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="xMidYMid slice">
                        <defs>
                            <linearGradient id="grad6" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="60%" stop-color="transparent"/>
                                <stop offset="100%" stop-color="rgba(0,0,0,0.55)"/>
                            </linearGradient>
                        </defs>
                        <rect width="400" height="480" fill="#1a2f4a"/>
                        <!-- Grid background -->
                        <?php for($i=0;$i<25;$i++): ?>
                        <line x1="0" y1="<?=$i*20?>" x2="400" y2="<?=$i*20?>" stroke="#2a4060" stroke-width="0.5"/>
                        <?php endfor; ?>
                        <?php for($i=0;$i<21;$i++): ?>
                        <line x1="<?=$i*20?>" y1="0" x2="<?=$i*20?>" y2="480" stroke="#2a4060" stroke-width="0.5"/>
                        <?php endfor; ?>
                        <!-- Gantt chart bars -->
                        <rect x="40" y="80" width="20" height="28" rx="2" fill="#4ecdc4" opacity="0.9"/>
                        <rect x="40" y="80" width="180" height="28" rx="2" fill="#4ecdc4" opacity="0.3"/>
                        <rect x="40" y="120" width="20" height="28" rx="2" fill="#4ecdc4" opacity="0.9"/>
                        <rect x="40" y="120" width="280" height="28" rx="2" fill="#4ecdc4" opacity="0.3"/>
                        <rect x="80" y="160" width="20" height="28" rx="2" fill="#f5c842" opacity="0.9"/>
                        <rect x="80" y="160" width="220" height="28" rx="2" fill="#f5c842" opacity="0.3"/>
                        <rect x="140" y="200" width="20" height="28" rx="2" fill="#4ecdc4" opacity="0.9"/>
                        <rect x="140" y="200" width="160" height="28" rx="2" fill="#4ecdc4" opacity="0.3"/>
                        <rect x="180" y="240" width="20" height="28" rx="2" fill="#e07b2a" opacity="0.9"/>
                        <rect x="180" y="240" width="140" height="28" rx="2" fill="#e07b2a" opacity="0.3"/>
                        <!-- Labels -->
                        <text x="36" y="99" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">Planning</text>
                        <text x="36" y="139" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">Design</text>
                        <text x="36" y="179" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">Engineering</text>
                        <text x="36" y="219" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">Construction</text>
                        <text x="36" y="259" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">Handover</text>
                        <!-- Circular progress -->
                        <circle cx="200" cy="370" r="70" fill="none" stroke="#2a4060" stroke-width="12"/>
                        <circle cx="200" cy="370" r="70" fill="none" stroke="#4ecdc4" stroke-width="12"
                                stroke-dasharray="<?=2*3.14159*70*0.72?> <?=2*3.14159*70?>"
                                stroke-dashoffset="<?=2*3.14159*70*0.25?>" stroke-linecap="round"/>
                        <text x="200" y="364" text-anchor="middle" font-family="Montserrat,sans-serif" font-size="22" font-weight="900" fill="#fff">72%</text>
                        <text x="200" y="382" text-anchor="middle" font-family="Montserrat,sans-serif" font-size="9" fill="#a0c8e0">On Track</text>
                        <!-- Overlay -->
                        <rect width="400" height="480" fill="url(#grad6)"/>
                    </svg>
                </div>
                <div class="offer-card-label">Project Management &amp; Supervision</div>
            </div>
            <?php endif; // end empty($offerServices) fallback ?>

        </div><!-- /.offer-track -->

        <!-- Next arrow -->
        <button class="offer-arrow offer-arrow--next" id="offerNext" aria-label="Next">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div><!-- /.offer-slider-wrap -->

    <!-- Dots (1 per scroll position at desktop: total - 2 for 3-visible) -->
    <?php
    $offerCount = !empty($offerServices) ? count($offerServices) : 6;
    $offerDots  = max(1, $offerCount - 2);
    ?>
    <div class="offer-dots" id="offerDots">
        <?php for ($d = 0; $d < $offerDots; $d++): ?>
        <button class="offer-dot <?= $d === 0 ? 'active' : '' ?>" data-index="<?= $d ?>"></button>
        <?php endfor; ?>
    </div>

</section>

<!-- =============================================
     CONTACT SECTION
     ============================================= -->
<section class="contact-us-section reveal">
    <div class="contact-us-inner">

        <h2 class="contact-us-heading"><span class="contact-heading-dark">CONTACT</span> <span class="contact-heading-teal">US</span></h2>
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
                    <p class="contact-us-text"><?= setting($settings, 'address', 'Wisma Jaya Jalan Kusuma Utara III Blok 5 Nomor 15, Durenjaya, Bekasi Timur, Kota Bekasi') ?></p>
                </div>
                <div class="contact-us-item">
                    <div class="contact-us-icon contact-icon-email">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <p class="contact-us-text">email : <?= setting($settings, 'company_email', 'hostruc@gmail.com') ?></p>
                </div>
                <div class="contact-us-item">
                    <div class="contact-us-icon contact-icon-phone">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <p class="contact-us-text">Phone :<br><?= setting($settings, 'phone_triono', '0856-9378-5271') ?> (Triono)<br><?= setting($settings, 'phone_farhan', '0858-4611-0978') ?> (Farhan)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
