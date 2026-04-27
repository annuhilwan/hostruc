<?php
/**
 * Auto-detect the application base URL.
 * Works whether the site is installed at root (domain.com/)
 * or in a subdirectory (domain.com/hostruc/).
 */
if (!defined('BASE')) {
    $scriptDir = dirname($_SERVER['SCRIPT_NAME']); // e.g. /hostruc  or  /hostruc/pages  or  /
    $base = preg_replace('#/pages$#', '', $scriptDir); // strip /pages suffix
    $base = rtrim($base === '.' ? '' : $base, '/');   // clean up
    define('BASE', $base);
}
