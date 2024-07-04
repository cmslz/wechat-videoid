<?php
/**
 * Each engineer has a duty to keep the code elegant
 * Created by xiaobai at 2024/6/12 上午11:46
 */

ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('memory_limit', '1G');

error_reporting(E_ALL);
date_default_timezone_set('Asia/Shanghai');
!defined('BASE_PATH') && define('BASE_PATH', dirname(__DIR__, 1));

require BASE_PATH . '/vendor/autoload.php';