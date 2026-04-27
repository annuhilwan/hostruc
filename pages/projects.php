<?php
$pageTitle = 'Projects - HOSTRUC';
$activePage = 'projects';

// Load config early so BASE is available before header.php
require_once '../includes/config.php';

// Scan Project- images automatically
$imgDir   = __DIR__ . '/../assets/images/';

// Use GLOB_BRACE if available; fall back to merging separate globs
if (defined('GLOB_BRACE')) {
    $imgFiles = glob($imgDir . 'Project-*.{png,jpg,jpeg,webp}', GLOB_BRACE) ?: [];
} else {
    $imgFiles = array_merge(
        glob($imgDir . 'Project-*.png')  ?: [],
        glob($imgDir . 'Project-*.jpg')  ?: [],
        glob($imgDir . 'Project-*.jpeg') ?: [],
        glob($imgDir . 'Project-*.webp') ?: []
    );
}
sort($imgFiles);

// Derive project name from filename
function nameFromFile(string $path): string {
    $base = pathinfo($path, PATHINFO_FILENAME); // e.g. Project-NDC-Hotels-and-Resort
    $name = preg_replace('/^Project-/i', '', $base); // NDC-Hotels-and-Resort
    return str_replace('-', ' ', $name);             // NDC Hotels and Resort
}

// Simple category inference from name keywords
function categoryFromName(string $name): string {
    $n = strtolower($name);
    if (strpos($n, 'hotel') !== false || strpos($n, 'resort') !== false || strpos($n, 'lombok') !== false || strpos($n, 'samara') !== false)
        return 'Hospitality';
    if (strpos($n, 'rusun') !== false || strpos($n, 'residential') !== false || strpos($n, 'apartemen') !== false)
        return 'Residential';
    if (strpos($n, 'dryer') !== false || strpos($n, 'crane') !== false || strpos($n, 'industrial') !== false ||
        strpos($n, 'industri') !== false || strpos($n, 'automotive') !== false || strpos($n, 'workshop') !== false ||
        strpos($n, 'looping') !== false || strpos($n, 'wilmar') !== false)
        return 'Industrial';
    if (strpos($n, 'jetty') !== false || strpos($n, 'terminal') !== false || strpos($n, 'jembatan') !== false)
        return 'Infrastructure';
    return 'Multipurpose';
}

$projects = [];
foreach ($imgFiles as $idx => $path) {
    $name     = nameFromFile($path);
    $filename = pathinfo($path, PATHINFO_BASENAME);
    $projects[] = [
        'id'       => $idx + 1,
        'title'    => $name,
        'file'     => $filename,
        'imgUrl'   => BASE . '/assets/images/' . $filename,
        'category' => categoryFromName($name),
    ];
}

// Output HTML only after all PHP logic succeeds
require_once '../includes/header.php';
?>

<!-- =============================================
     HERO
     ============================================= -->
<section class="hero">
    <div class="hero-text-block">
        <h1 class="hero-title">Our<br>Projects</h1>
    </div>
    <div class="hero-image-wrap">
        <img src="https://images.unsplash.com/photo-1524084097008-2e5f24586388?auto=format&fit=crop&w=1920&q=80"
             alt="HOSTRUC Projects" loading="eager">
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
     PROJECTS GRID
     ============================================= -->
<section class="projects-section">
    <div class="projects-inner">
        <h2 class="section-title reveal">Project Portfolio</h2>

        <?php if (empty($projects)): ?>
            <p style="color:#888;text-align:center;padding:40px 0;">No project photos available yet.</p>
        <?php else: ?>
        <div class="projects-grid reveal">
            <?php foreach ($projects as $idx => $p): ?>
            <div class="project-card" onclick="openProjectModal(<?= $idx ?>)">
                <div class="project-image">
                    <img src="<?= htmlspecialchars($p['imgUrl']) ?>"
                         alt="<?= htmlspecialchars($p['title']) ?>"
                         class="project-img" loading="lazy">
                    <div class="project-img-overlay">
                        <span class="project-img-zoom"><i class="fas fa-expand-alt"></i></span>
                    </div>
                </div>
                <div class="project-info">
                    <div class="project-category"><?= htmlspecialchars($p['category']) ?></div>
                    <h3 class="project-title"><?= htmlspecialchars($p['title']) ?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- =============================================
     PROJECT MODAL
     ============================================= -->
<div id="projectModal" class="modal">
    <div class="modal-content modal-content--project">
        <button class="modal-close" onclick="closeProjectModal()">✕</button>
        <div class="modal-project-img-wrap">
            <img id="modalProjectImg" src="" alt="" class="modal-project-img">
        </div>
        <div class="modal-project-info">
            <div class="project-category" id="modalCategory"></div>
            <h2 class="modal-project-title" id="modalTitle"></h2>
        </div>
    </div>
</div>

<!-- =============================================
     CTA STRIP
     ============================================= -->
<div class="intro-strip">
    <div class="intro-inner">
        <div class="intro-content">
            <div class="intro-company">BRING YOUR PROJECT TO LIFE</div>
            <div class="intro-tagline">Join the clients who have trusted us to bring their vision to life.</div>
        </div>
        <a href="<?= BASE ?>/pages/contact.php" class="intro-arrow" style="cursor:pointer;">→</a>
    </div>
</div>

<script>
const projectsData = <?php echo json_encode($projects, JSON_UNESCAPED_UNICODE); ?>;

function openProjectModal(index) {
    const p = projectsData[index];
    if (!p) return;
    document.getElementById('modalTitle').textContent    = p.title;
    document.getElementById('modalCategory').textContent = p.category;
    document.getElementById('modalProjectImg').src       = p.imgUrl;
    document.getElementById('modalProjectImg').alt       = p.title;
    document.getElementById('projectModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeProjectModal() {
    document.getElementById('projectModal').classList.remove('active');
    document.body.style.overflow = '';
}

document.getElementById('projectModal').addEventListener('click', function(e) {
    if (e.target === this) closeProjectModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeProjectModal();
});
</script>

<?php require_once '../includes/footer.php'; ?>
