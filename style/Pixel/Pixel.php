<?php
/**
 * Pixel theme registration file for PunBB 1.4.6
 * Based on Bootstrap 5 + Pixel UI Kit
 * Offline-only: no external CDN references
 *
 * @copyright (C) 2026 wenyinos
 * @license GPL v2
 */

if (!defined('FORUM'))
    exit;

// Bootstrap 5 CSS
$forum_loader->add_css($base_url.'/style/Pixel/vendor/bootstrap/css/bootstrap.min.css', array('type' => 'url', 'weight' => 5, 'group' => FORUM_CSS_GROUP_SYSTEM));

// Bootstrap 5 JS (bundle includes Popper.js)
$forum_loader->add_js($base_url.'/style/Pixel/vendor/bootstrap/js/bootstrap.bundle.min.js', array('type' => 'url', 'weight' => 5, 'async' => false, 'group' => FORUM_JS_GROUP_SYSTEM));

// FontAwesome 6 CSS
$forum_loader->add_css($base_url.'/style/Pixel/vendor/fontawesome/css/all.min.css', array('type' => 'url', 'weight' => 6, 'group' => FORUM_CSS_GROUP_SYSTEM));

// Pixel theme CSS (PunBB → Bootstrap 5 bridge) — version param for cache busting
$forum_loader->add_css($base_url.'/style/Pixel/Pixel.min.css?v=1.4', array('type' => 'url', 'weight' => 100, 'group' => FORUM_CSS_GROUP_DEFAULT));
