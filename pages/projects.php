<?php
$pageTitle = 'Projects - HOSTRUC';
$activePage = 'projects';
require_once '../includes/config.php';
require_once '../includes/db_connect.php';
if (!isset($settings)) $settings = loadSettings($conn);

$imgDir = __DIR__ . '/../assets/images/';

// Try to load projects from DB
$allProjects = [];
if ($conn) {
    $res = $conn->query("SELECT * FROM projects WHERE active=1 ORDER BY no_urut, id");
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $imgUrl = null;
            if (!empty($row['image'])) {
                $img = $row['image'];
                if (str_starts_with($img, 'http') || str_starts_with($img, '/')) {
                    $imgUrl = $img;
                } else {
                    $imgUrl = BASE . '/assets/images/' . $img;
                }
            }
            $allProjects[] = [
                'no'       => $row['no_urut'] ?: $row['id'],
                'title'    => $row['title'],
                'client'   => $row['client'] ?? '-',
                'lokasi'   => $row['location'] ?? '-',
                'year'     => $row['year'] ?? '-',
                'category' => $row['category'] ?? 'Multipurpose',
                'imgUrl'   => $imgUrl,
            ];
        }
    }
}

// Fallback: hardcoded project list
if (empty($allProjects)) {
    $imageMap = [
        1  => 'Project-Rusun-Kemensos-Solo.png',
        2  => 'Project-Desa-Binaan-Kalimantan-Tengah.png',
        3  => 'Project-Dryer-Building-Wilmar-Palembang.png',
        4  => 'Project-New-supporting-Crane-Industri-Facility.png',
        5  => 'Project-Perbaikan-Jetty-Head-Full-Terminal-Tobelo.png',
        10 => 'Project-NDC-Hotels-and-Resort.png',
        17 => 'Project-Samara-Lombok.png',
        19 => 'Project-Looping-Hanger-Automotive-Workshop.png',
    ];
    $allProjects = [
        ['no'=>1,  'title'=>'Rusun Kemensos Solo',                                        'client'=>'Kemensos RI',                     'lokasi'=>'Solo',             'year'=>'2021',      'category'=>'Residential'],
        ['no'=>2,  'title'=>'Desa Binaan Kalimantan Tengah',                              'client'=>'-',                               'lokasi'=>'Kalimantan Tengah','year'=>'2021',      'category'=>'Multipurpose'],
        ['no'=>3,  'title'=>'Dryer Building Wilmar Palembang',                            'client'=>'PT. Wilmar',                      'lokasi'=>'Palembang',        'year'=>'2022',      'category'=>'Industrial'],
        ['no'=>4,  'title'=>'New Supporting Crane Industri Facility',                     'client'=>'-',                               'lokasi'=>'-',                'year'=>'2022',      'category'=>'Industrial'],
        ['no'=>5,  'title'=>'Perbaikan Jetty Head Full Terminal Tobelo',                  'client'=>'-',                               'lokasi'=>'Tobelo',           'year'=>'2022',      'category'=>'Infrastructure'],
        ['no'=>10, 'title'=>'NDC Resort',                                                 'client'=>'PT. Megatika International',       'lokasi'=>'Manado',           'year'=>'2022',      'category'=>'Hospitality'],
        ['no'=>12, 'title'=>'Upstream & Downstream Drinking Water Supply',                'client'=>'PT. Envitech Perkasa',             'lokasi'=>'Aceh',             'year'=>'2023',      'category'=>'Infrastructure'],
        ['no'=>13, 'title'=>'Assesment PT. Nissho & Restrengthening Structure',           'client'=>'PT. Nissho Indonesia',             'lokasi'=>'Cikarang',         'year'=>'2023',      'category'=>'Industrial'],
        ['no'=>14, 'title'=>'Gedung Kemala Bhayangkari',                                  'client'=>'-',                               'lokasi'=>'Jakarta Selatan',  'year'=>'2023',      'category'=>'Multipurpose'],
        ['no'=>15, 'title'=>'Assesment & Extension PLKD Jakarta Selatan',                'client'=>'PLKD Jakarta Selatan',             'lokasi'=>'Jakarta Selatan',  'year'=>'2023',      'category'=>'Multipurpose'],
        ['no'=>16, 'title'=>'Eco Urban Park Deltamas',                                    'client'=>'PT. Kota Deltamas',                'lokasi'=>'Cikarang',         'year'=>'2023',      'category'=>'Multipurpose'],
        ['no'=>17, 'title'=>'Samara SH26, SH Y5, W9',                                    'client'=>'PT. Lombok Torok Development',     'lokasi'=>'Lombok',           'year'=>'2022–2023', 'category'=>'Hospitality'],
        ['no'=>19, 'title'=>'Lopping Hanger Automotive Industrial',                       'client'=>'PT. Eletromech Manufacturing',     'lokasi'=>'Bogor',            'year'=>'2024',      'category'=>'Industrial'],
        ['no'=>20, 'title'=>'BYD Auto Indonesia',                                         'client'=>'Holding Dongyang Institute Wuhan', 'lokasi'=>'Subang',           'year'=>'2024',      'category'=>'Industrial'],
        ['no'=>21, 'title'=>'Reload Saturacy Bali',                                       'client'=>'PT. Reload',                      'lokasi'=>'Bali',             'year'=>'2024',      'category'=>'Multipurpose'],
        ['no'=>22, 'title'=>'Extension PT. Framas Manufacturing',                         'client'=>'PT. Eletromech Manufacturing',     'lokasi'=>'Cikarang',         'year'=>'2024',      'category'=>'Industrial'],
        ['no'=>23, 'title'=>'Audit & Restrengthening Structure Blueschope due Vibration', 'client'=>'PT. Eletromech Manufacturing',     'lokasi'=>'Cikarang',         'year'=>'2024',      'category'=>'Industrial'],
        ['no'=>24, 'title'=>'Plant Mixing + RMWH PT. Gajah Tunggal Tbk',                 'client'=>'PT. PEB Steel',                   'lokasi'=>'Tangerang',        'year'=>'2025',      'category'=>'Industrial'],
        ['no'=>25, 'title'=>'MCG Workshop',                                               'client'=>'PT. Mandiri Inti Perkasa',         'lokasi'=>'Kalimantan',       'year'=>'2025',      'category'=>'Industrial'],
        ['no'=>26, 'title'=>'TRI Golden Star Extension',                                  'client'=>'PT. Tri Golden Star',             'lokasi'=>'Karawang',         'year'=>'2025',      'category'=>'Industrial'],
    ];
    foreach ($allProjects as &$p) {
        $no = $p['no'];
        $p['imgUrl'] = (isset($imageMap[$no]) && file_exists($imgDir . $imageMap[$no]))
            ? BASE . '/assets/images/' . $imageMap[$no]
            : null;
    }
    unset($p);
}

$perPage    = 9;
$totalPages = (int) ceil(count($allProjects) / $perPage);

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

        <div class="projects-grid reveal" id="projectsGrid">
            <?php foreach ($allProjects as $idx => $p): ?>
            <div class="project-card"
                 data-page="<?= floor($idx / $perPage) + 1 ?>"
                 style="<?= floor($idx / $perPage) + 1 > 1 ? 'display:none' : '' ?>"
                 onclick="openProjectModal(<?= $idx ?>)">
                <div class="project-image">
                    <?php if ($p['imgUrl']): ?>
                        <img src="<?= htmlspecialchars($p['imgUrl']) ?>"
                             alt="<?= htmlspecialchars($p['title']) ?>"
                             class="project-img" loading="lazy">
                    <?php else: ?>
                        <div class="project-image-placeholder">
                            <div class="proj-placeholder-inner">
                                <i class="fas fa-building"></i>
                                <span><?= htmlspecialchars($p['lokasi']) ?> · <?= htmlspecialchars($p['year']) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="project-img-overlay">
                        <span class="project-img-zoom"><i class="fas fa-expand-alt"></i></span>
                    </div>
                </div>
                <div class="project-info">
                    <div class="project-category"><?= htmlspecialchars($p['category']) ?></div>
                    <h3 class="project-title"><?= htmlspecialchars($p['title']) ?></h3>
                    <p class="project-meta"><?= htmlspecialchars($p['client'] !== '-' ? $p['client'] : '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
        <div class="proj-pagination">
            <button class="proj-page-btn" id="projPrev" onclick="projChangePage(-1)" disabled>&#8249;</button>
            <?php for ($pg = 1; $pg <= $totalPages; $pg++): ?>
            <button class="proj-page-dot <?= $pg === 1 ? 'active' : '' ?>"
                    onclick="projGoTo(<?= $pg ?>)"
                    id="projDot<?= $pg ?>"><?= $pg ?></button>
            <?php endfor; ?>
            <button class="proj-page-btn" id="projNext" onclick="projChangePage(1)">&#8250;</button>
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
        <div class="modal-project-img-wrap" id="modalImgWrap">
            <img id="modalProjectImg" src="" alt="" class="modal-project-img">
        </div>
        <div class="modal-project-info">
            <div class="project-category" id="modalCategory"></div>
            <h2 class="modal-project-title" id="modalTitle"></h2>
            <p class="modal-project-meta" id="modalMeta"></p>
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
const projectsData = <?php echo json_encode($allProjects, JSON_UNESCAPED_UNICODE); ?>;
let currentPage = 1;
const totalPages = <?= $totalPages ?>;

function projGoTo(page) {
    currentPage = page;
    document.querySelectorAll('.project-card').forEach(function(card) {
        card.style.display = parseInt(card.dataset.page) === page ? '' : 'none';
    });
    for (let i = 1; i <= totalPages; i++) {
        const dot = document.getElementById('projDot' + i);
        if (dot) dot.classList.toggle('active', i === page);
    }
    document.getElementById('projPrev').disabled = page === 1;
    document.getElementById('projNext').disabled = page === totalPages;
    document.querySelector('.projects-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function projChangePage(dir) { projGoTo(currentPage + dir); }

function openProjectModal(index) {
    const p = projectsData[index];
    if (!p) return;
    document.getElementById('modalTitle').textContent    = p.title;
    document.getElementById('modalCategory').textContent = p.category;
    const meta = [p.client !== '-' ? p.client : '', p.lokasi, p.year].filter(Boolean).join(' · ');
    document.getElementById('modalMeta').textContent = meta;
    const imgEl = document.getElementById('modalProjectImg');
    const wrap  = document.getElementById('modalImgWrap');
    if (p.imgUrl) {
        imgEl.src = p.imgUrl;
        imgEl.alt = p.title;
        wrap.style.display = '';
    } else {
        wrap.style.display = 'none';
    }
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
