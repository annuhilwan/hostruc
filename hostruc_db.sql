-- HOSTRUC Database Schema
-- Import via phpMyAdmin

CREATE DATABASE IF NOT EXISTS `hostruc_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `hostruc_db`;

-- Projects table
CREATE TABLE IF NOT EXISTS `projects` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(200) NOT NULL,
    `slug`        VARCHAR(220) NOT NULL UNIQUE,
    `category`    VARCHAR(100) NOT NULL DEFAULT 'Architecture',
    `description` TEXT,
    `detail`      LONGTEXT,
    `image`       VARCHAR(300),
    `location`    VARCHAR(150),
    `year`        YEAR,
    `featured`    TINYINT(1) DEFAULT 0,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Services table
CREATE TABLE IF NOT EXISTS `services` (
    `id`          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(200) NOT NULL,
    `slug`        VARCHAR(220) NOT NULL UNIQUE,
    `icon`        VARCHAR(100),
    `summary`     TEXT,
    `detail`      LONGTEXT,
    `sort_order`  INT DEFAULT 0,
    `created_at`  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Contact messages table
CREATE TABLE IF NOT EXISTS `contacts` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`       VARCHAR(150) NOT NULL,
    `email`      VARCHAR(200) NOT NULL,
    `phone`      VARCHAR(30),
    `subject`    VARCHAR(250),
    `message`    TEXT NOT NULL,
    `is_read`    TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Seed: sample projects
INSERT INTO `projects` (`title`, `slug`, `category`, `description`, `location`, `year`, `featured`) VALUES
('The Pavilion', 'the-pavilion', 'Architecture', 'Atap kayu parametrik dengan desain organik yang memadukan estetika dan fungsi.', 'Jakarta, Indonesia', 2024, 1),
('Bio-Tower', 'bio-tower', 'Commercial', 'Menara komersial ramah lingkungan dengan sistem fasad hijau vertikal.', 'Surabaya, Indonesia', 2025, 1),
('Hybrid Office Complex', 'hybrid-office-complex', 'Commercial', 'Gedung perkantoran hibrida dengan konsep ruang fleksibel dan efisiensi energi tinggi.', 'Bandung, Indonesia', 2024, 0);

-- Seed: sample services
INSERT INTO `services` (`title`, `slug`, `icon`, `summary`, `sort_order`) VALUES
('Architectural Design', 'architectural-design', 'fa-drafting-compass', 'Desain arsitektur komprehensif dari konsep hingga konstruksi.', 1),
('Structural Engineering', 'structural-engineering', 'fa-industry', 'Analisis dan perencanaan struktur bangunan dengan standar internasional.', 2),
('MEP Engineering', 'mep-engineering', 'fa-cogs', 'Perancangan sistem mekanikal, elektrikal, dan plumbing terintegrasi.', 3),
('Sustainability Consulting', 'sustainability-consulting', 'fa-leaf', 'Konsultasi LEED/BREEAM dan strategi bangunan ramah lingkungan.', 4),
('Computational Design', 'computational-design', 'fa-microchip', 'Desain parametrik dan simulasi berbasis komputasi tingkat lanjut.', 5),
('Project Management', 'project-management', 'fa-project-diagram', 'Manajemen proyek terpadu dari perencanaan hingga serah terima.', 6);
