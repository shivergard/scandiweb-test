<?php

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Create framework instance
 */
$framework = new Sukonovs\Framework();

/**
 * Require routes
 */
require_once __DIR__ . '/../app/routes.php';

/**
 * Launch the framework
 */
$framework->launch();