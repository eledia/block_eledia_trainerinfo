<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'block/eledia_trainerinfo:addinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'editingteacher' => CAP_ALLOW,
            'manger' => CAP_ALLOW,
        ),

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ),
);
