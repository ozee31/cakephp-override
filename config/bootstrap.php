<?php
use Cake\Core\Configure;

try {
    Configure::load('overrides', 'default');
} catch (\Exception $e) {
    exit($e->getMessage() . "\n");
}

