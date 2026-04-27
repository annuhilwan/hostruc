<?php
/**
 * HOSTRUC Admin Setup
 * Run once: http://localhost/hostruc/admin/setup.php
 * Delete this file after setup is complete.
 */

// Connect WITHOUT database first so we can create it
$conn = new mysqli('localhost', 'root', '');
if ($conn->connect_error) {
    die('<h2 style="color:red">MySQL connection failed: ' . htmlspecialchars($conn->connect_error) . '</h2><p>Make sure XAMPP MySQL is running.</p>');
}
$conn->set_charset('utf8mb4');

// Create database if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS `hostruc_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$conn->select_db('hostruc_db');

$errors = [];
$ok     = [];

$sql = "
-- Admin users
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username`     VARCHAR(80) NOT NULL UNIQUE,
    `password`     VARCHAR(255) NOT NULL,
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Site settings (key-value)
CREATE TABLE IF NOT EXISTS `settings` (
    `id`       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `grp`      VARCHAR(60) NOT NULL DEFAULT 'general',
    `key_name` VARCHAR(100) NOT NULL UNIQUE,
    `label`    VARCHAR(150) NOT NULL,
    `value`    TEXT
) ENGINE=InnoDB;

-- Hero slides
CREATE TABLE IF NOT EXISTS `hero_slides` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(200),
    `subtitle`   VARCHAR(300),
    `image_url`  VARCHAR(500),
    `sort_order` INT DEFAULT 0,
    `active`     TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Career positions
CREATE TABLE IF NOT EXISTS `career_positions` (
    `id`           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`        VARCHAR(200) NOT NULL,
    `location`     VARCHAR(150),
    `description`  TEXT,
    `job_desc`     TEXT,
    `requirements` TEXT,
    `active`       TINYINT(1) DEFAULT 1,
    `sort_order`   INT DEFAULT 0,
    `created_at`   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Page content blocks
CREATE TABLE IF NOT EXISTS `page_content` (
    `id`        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `page`      VARCHAR(60) NOT NULL,
    `section`   VARCHAR(80) NOT NULL,
    `key_name`  VARCHAR(100) NOT NULL,
    `label`     VARCHAR(150) NOT NULL,
    `value`     LONGTEXT,
    UNIQUE KEY `page_section_key` (`page`, `section`, `key_name`)
) ENGINE=InnoDB;

-- Services
CREATE TABLE IF NOT EXISTS `services` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`      VARCHAR(200) NOT NULL,
    `slug`       VARCHAR(220),
    `icon`       VARCHAR(100),
    `summary`    TEXT,
    `detail`     TEXT,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Projects
CREATE TABLE IF NOT EXISTS `projects` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `no_urut`     INT DEFAULT 0,
    `title`       VARCHAR(250) NOT NULL,
    `slug`        VARCHAR(270),
    `client`      VARCHAR(200),
    `structure`   VARCHAR(100),
    `category`    VARCHAR(80) DEFAULT 'Multipurpose',
    `location`    VARCHAR(150),
    `year`        VARCHAR(20),
    `description` TEXT,
    `image`       VARCHAR(500),
    `active`      TINYINT(1) DEFAULT 1,
    `featured`    TINYINT(1) DEFAULT 0,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact messages
CREATE TABLE IF NOT EXISTS `contacts` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`       VARCHAR(150),
    `email`      VARCHAR(200),
    `phone`      VARCHAR(50),
    `subject`    VARCHAR(250),
    `message`    TEXT,
    `is_read`    TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
";

// Run each statement
foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
    if ($conn->query($stmt) === false) {
        $errors[] = htmlspecialchars($conn->error) . ' &mdash; ' . htmlspecialchars(substr($stmt, 0, 80));
    } else {
        $ok[] = substr(trim($stmt), 0, 60) . '...';
    }
}

// Default admin user
$username = 'admin';
$password = password_hash('hostruc2024', PASSWORD_BCRYPT);
$conn->query("INSERT IGNORE INTO `admin_users` (`username`, `password`) VALUES ('$username', '$password')");

// Default settings
$defaults = [
    ['general','company_name',   'Company Name',        'CV. Holistika Strukturindo Konsultant'],
    ['general','company_tagline','Tagline',              'Holistic Approach to Building Design'],
    ['general','company_email',  'Email',                'hostruc@gmail.com'],
    ['general','phone_triono',   'Phone (Triono)',       '0856-9378-5271'],
    ['general','phone_farhan',   'Phone (Farhan)',       '0858-4611-0978'],
    ['general','address',        'Address',              'Wisma Jaya Jalan Kusuma Utara III Blok 5 Nomor 15, Durenjaya, Bekasi Timur, Kota Bekasi'],
    ['general','instagram',      'Instagram URL',        'https://www.instagram.com/hostruc_consulting'],
    ['general','whatsapp',       'WhatsApp Number',      '6285846110978'],
    ['general','akta_no',        'Akta Pendirian No.',   'No. 23, 21 August 2025'],
    ['hero',   'hero_title',     'Hero Title',           'Building Value Through<br>Holistic Vision'],
    ['about',  'about_intro',    'About Intro Paragraph','Holistika Strukturindo Konsultan is a consultancy firm specializing in building design and construction services.'],
    ['about',  'vision',         'Vision',               'To become the leading design consultant known for our holistic approach, high-quality work, and integrity.'],
    ['about',  'mission',        'Mission',              'Hostruc is committed to delivering design services that go beyond just solving technical, aesthetic, economic, environmental, and sustainability challenges.'],
];
foreach ($defaults as [$grp, $key, $label, $val]) {
    $grp   = $conn->real_escape_string($grp);
    $key   = $conn->real_escape_string($key);
    $label = $conn->real_escape_string($label);
    $val   = $conn->real_escape_string($val);
    $conn->query("INSERT IGNORE INTO `settings` (`grp`,`key_name`,`label`,`value`) VALUES ('$grp','$key','$label','$val')");
}

// Default hero slides (use local images as fallback)
$heroSlides = [
    ['/hostruc/assets/images/hero.png',   'Building Value Through Holistic Vision', 1],
    ['/hostruc/assets/images/career.png', 'Join Our Team',                          2],
];
foreach ($heroSlides as [$img, $title, $sort]) {
    $img   = $conn->real_escape_string($img);
    $title = $conn->real_escape_string($title);
    $conn->query("INSERT IGNORE INTO `hero_slides` (`image_url`,`title`,`sort_order`,`active`) VALUES ('$img','$title',$sort,1)");
}

// Default services
$services = [
    ['Architectural Design',                             'fa-drafting-compass', 'Designing buildings that are aesthetic, functional, and in harmony with their surroundings.',                        'Full architectural design services from concept to construction drawings, including 2D plans and 3D visualizations.', 1],
    ['Structural Design & Structural Engineering',       'fa-ruler-combined',   'Providing strong, efficient, and sustainability-oriented structural solutions.',                                    'Structural analysis, calculation, and design for all building types including concrete and steel structures.',         2],
    ['MEP (Mechanical, Electrical & Plumbing)',          'fa-cogs',             'Planning integrated and reliable utility systems for buildings.',                                                   'Comprehensive MEP engineering including HVAC, electrical systems, plumbing, and data & voice infrastructure.',         3],
    ['Project Management',                               'fa-tasks',            'Comprehensive project oversight with optimal control of quality, cost, and schedule.',                             'End-to-end project management, site supervision, and quality control to ensure projects are delivered on time.',      4],
    ['Value Engineering',                                'fa-chart-line',       'Optimizing design and cost without compromising on quality or building performance.',                              'Cost analysis and design optimization to maximize value and efficiency for every project.',                           5],
    ['PBG & SLF Permit Assistance',                     'fa-file-alt',         'Professional support throughout the entire building permit process.',                                               'Assistance with Building Approval (PBG) and Occupancy Certificate (SLF) permits from start to finish.',              6],
];
foreach ($services as [$title, $icon, $summary, $detail, $sort]) {
    $slug    = $conn->real_escape_string(strtolower(preg_replace('/[^a-z0-9]+/', '-', $title)) . '-' . $sort);
    $title   = $conn->real_escape_string($title);
    $icon    = $conn->real_escape_string($icon);
    $summary = $conn->real_escape_string($summary);
    $detail  = $conn->real_escape_string($detail);
    $conn->query("INSERT IGNORE INTO `services` (`title`,`slug`,`icon`,`summary`,`detail`,`sort_order`) VALUES ('$title','$slug','$icon','$summary','$detail',$sort)");
}

// Default projects
$projects = [
    [1,  'Rusun Kemensos Solo',                                        'rusun-kemensos-solo-1',                                  'Kemensos RI',                     'Residential',   'Solo',             '2021',      'Concrete & Steel', '/hostruc/assets/images/Project-Rusun-Kemensos-Solo.png',                  1, 0],
    [2,  'Desa Binaan Kalimantan Tengah',                              'desa-binaan-kalimantan-tengah-2',                        '',                                'Multipurpose',  'Kalimantan Tengah','2021',      '',                 '/hostruc/assets/images/Project-Desa-Binaan-Kalimantan-Tengah.png',        1, 0],
    [3,  'Dryer Building Wilmar Palembang',                            'dryer-building-wilmar-palembang-3',                      'PT. Wilmar',                      'Industrial',    'Palembang',        '2022',      'Steel Structure',  '/hostruc/assets/images/Project-Dryer-Building-Wilmar-Palembang.png',      1, 0],
    [4,  'New Supporting Crane Industri Facility',                     'new-supporting-crane-industri-facility-4',               '',                                'Industrial',    '',                 '2022',      '',                 '/hostruc/assets/images/Project-New-supporting-Crane-Industri-Facility.png',1, 0],
    [5,  'Perbaikan Jetty Head Full Terminal Tobelo',                  'perbaikan-jetty-head-full-terminal-tobelo-5',            '',                                'Infrastructure','Tobelo',           '2022',      '',                 '/hostruc/assets/images/Project-Perbaikan-Jetty-Head-Full-Terminal-Tobelo.png',1,0],
    [10, 'NDC Resort',                                                 'ndc-resort-10',                                          'PT. Megatika International',      'Hospitality',   'Manado',           '2022',      '',                 '/hostruc/assets/images/Project-NDC-Hotels-and-Resort.png',                1, 1],
    [12, 'Upstream & Downstream Drinking Water Supply',                'upstream-downstream-drinking-water-supply-12',           'PT. Envitech Perkasa',            'Infrastructure','Aceh',             '2023',      '',                 '',                                                                        1, 0],
    [13, 'Assesment PT. Nissho & Restrengthening Structure',           'assesment-pt-nissho-restrengthening-structure-13',       'PT. Nissho Indonesia',            'Industrial',    'Cikarang',         '2023',      '',                 '',                                                                        1, 0],
    [14, 'Gedung Kemala Bhayangkari',                                  'gedung-kemala-bhayangkari-14',                           '',                                'Multipurpose',  'Jakarta Selatan',  '2023',      '',                 '',                                                                        1, 0],
    [15, 'Assesment & Extension PLKD Jakarta Selatan',                 'assesment-extension-plkd-jakarta-selatan-15',            'PLKD Jakarta Selatan',            'Multipurpose',  'Jakarta Selatan',  '2023',      '',                 '',                                                                        1, 0],
    [16, 'Eco Urban Park Deltamas',                                    'eco-urban-park-deltamas-16',                             'PT. Kota Deltamas',               'Multipurpose',  'Cikarang',         '2023',      '',                 '',                                                                        1, 0],
    [17, 'Samara SH26, SH Y5, W9',                                    'samara-sh26-sh-y5-w9-17',                                'PT. Lombok Torok Development',    'Hospitality',   'Lombok',           '2022-2023', '',                 '/hostruc/assets/images/Project-Samara-Lombok.png',                        1, 1],
    [19, 'Lopping Hanger Automotive Industrial',                       'lopping-hanger-automotive-industrial-19',                'PT. Eletromech Manufacturing',    'Industrial',    'Bogor',            '2024',      '',                 '/hostruc/assets/images/Project-Looping-Hanger-Automotive-Workshop.png',   1, 0],
    [20, 'BYD Auto Indonesia',                                         'byd-auto-indonesia-20',                                  'Holding Dongyang Institute Wuhan','Industrial',    'Subang',           '2024',      '',                 '',                                                                        1, 1],
    [21, 'Reload Saturacy Bali',                                       'reload-saturacy-bali-21',                                'PT. Reload',                      'Multipurpose',  'Bali',             '2024',      '',                 '',                                                                        1, 0],
    [22, 'Extension PT. Framas Manufacturing',                         'extension-pt-framas-manufacturing-22',                   'PT. Eletromech Manufacturing',    'Industrial',    'Cikarang',         '2024',      '',                 '',                                                                        1, 0],
    [23, 'Audit & Restrengthening Structure Blueschope due Vibration', 'audit-restrengthening-structure-blueschope-vibration-23','PT. Eletromech Manufacturing',    'Industrial',    'Cikarang',         '2024',      '',                 '',                                                                        1, 0],
    [24, 'Plant Mixing + RMWH PT. Gajah Tunggal Tbk',                 'plant-mixing-rmwh-pt-gajah-tunggal-24',                  'PT. PEB Steel',                   'Industrial',    'Tangerang',        '2025',      '',                 '',                                                                        1, 0],
    [25, 'MCG Workshop',                                               'mcg-workshop-25',                                        'PT. Mandiri Inti Perkasa',        'Industrial',    'Kalimantan',       '2025',      '',                 '',                                                                        1, 0],
    [26, 'TRI Golden Star Extension',                                  'tri-golden-star-extension-26',                           'PT. Tri Golden Star',             'Industrial',    'Karawang',         '2025',      '',                 '',                                                                        1, 0],
];
foreach ($projects as [$no,$title,$slug,$client,$cat,$loc,$year,$struct,$img,$active,$feat]) {
    $title  = $conn->real_escape_string($title);
    $slug   = $conn->real_escape_string($slug);
    $client = $conn->real_escape_string($client);
    $cat    = $conn->real_escape_string($cat);
    $loc    = $conn->real_escape_string($loc);
    $year   = $conn->real_escape_string($year);
    $struct = $conn->real_escape_string($struct);
    $img    = $conn->real_escape_string($img);
    $conn->query("INSERT IGNORE INTO `projects` (`no_urut`,`title`,`slug`,`client`,`category`,`location`,`year`,`structure`,`image`,`active`,`featured`) VALUES ($no,'$title','$slug','$client','$cat','$loc','$year','$struct','$img',$active,$feat)");
}

// Default career positions
$positions = [
    ['Arsitek Senior',        'Jakarta',           'Senior architect with minimum 8 years in commercial and residential building design.', '', '', 1, 1],
    ['Structural Engineer',   'Jakarta / Surabaya','Experienced structural engineer for design and structural calculations across various building types.', '', '', 1, 2],
    ['Junior Architect',      'Jakarta',           'Fresh graduate in Architecture to join our design team.', '', '', 1, 3],
    ['Drafter Struktur / Civil','Jakarta',         'Drafter for civil and structural design.',
        "1. Civil and structural design with emphasis on advanced steel design.\n2. Develop structural calculation and technical report.\n3. Conduct technical and feasibility studies with regards to structural design.\n4. Ensure design compliance in accordance to national standard.\n5. Coordinate with fellow engineer, architect, quantity surveyor and construction management in resolving site issues.",
        "1. Bachelor degree in Civil Engineering from reputable university, minimum grade IP 3.00.\n2. Fresh graduate are welcome.\n3. Proficient in: ETABS, STAADpro, Structural design software, AutoCad and Tekla.\n4. Disciplined, highly motivated, possess great leadership qualities, integrity and cooperation.\n5. Experience in design consultant or steel construction is an advantage.\n6. Able to work as an individual and team.\n7. Able to read and write in English.",
        1, 4],
];
foreach ($positions as [$title,$loc,$desc,$jd,$req,$active,$sort]) {
    $t = $conn->real_escape_string($title);
    $l = $conn->real_escape_string($loc);
    $d = $conn->real_escape_string($desc);
    $j = $conn->real_escape_string($jd);
    $r = $conn->real_escape_string($req);
    $conn->query("INSERT IGNORE INTO `career_positions` (`title`,`location`,`description`,`job_desc`,`requirements`,`active`,`sort_order`) VALUES ('$t','$l','$d','$j','$r',$active,$sort)");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>HOSTRUC Setup</title>
<style>
body{font-family:sans-serif;max-width:700px;margin:40px auto;padding:0 20px}
h1{color:#1a2f4a}
.ok{color:#2e7d32;margin:4px 0;font-size:.9rem}
.err{color:#c62828;margin:4px 0;font-size:.9rem}
.box{background:#f5f5f5;border-radius:8px;padding:20px;margin-top:24px}
.creds{background:#e8f5e9;border:1px solid #a5d6a7;padding:16px;border-radius:6px;margin-top:20px}
</style>
</head>
<body>
<h1>HOSTRUC — Database Setup</h1>

<?php if ($errors): ?>
<div class="box">
    <h3 style="color:#c62828">Errors:</h3>
    <?php foreach ($errors as $e): ?><p class="err">✗ <?= $e ?></p><?php endforeach; ?>
</div>
<?php endif; ?>

<div class="box">
    <h3 style="color:#2e7d32">Completed:</h3>
    <?php foreach ($ok as $s): ?><p class="ok">✓ <?= htmlspecialchars($s) ?></p><?php endforeach; ?>
</div>

<div class="creds">
    <strong>Setup complete!</strong><br><br>
    Admin login:<br>
    URL: <a href="index.php">admin/index.php</a><br>
    Username: <code>admin</code><br>
    Password: <code>hostruc2024</code><br><br>
    <strong style="color:#c62828">⚠ Delete this file (setup.php) after logging in!</strong>
</div>
</body>
</html>
