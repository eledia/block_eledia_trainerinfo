<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
global $DB;
$roles = $DB->get_records('role');
$roles = role_fix_names($roles);
$params = array();
foreach($roles as $role) {
    $params[$role->id] = $role->localname;
}


$settings->add(new admin_setting_configselect('block_eledia_trainerinfo_role_course',
    get_string('configure_eledia_trainerinfo_role_course_title', 'block_eledia_trainerinfo'),
    get_string('configure_eledia_trainerinfo_role_course', 'block_eledia_trainerinfo'),
            0,
            $params));
}