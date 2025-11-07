<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\FeedbackController;

$controller = new FeedbackController();
$controller->handleRequest();