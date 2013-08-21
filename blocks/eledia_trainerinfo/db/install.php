<?php

function xmldb_block_eledia_trainerinfo_install() {
    global $DB;

    $old_instances = $DB->get_records('block_instances', array('blockname' => 'eledia_referenten'));

    foreach ($old_instances as $instance) {
        $instance->blockname = 'eledia_trainerinfo';
        $DB->update_record('block_instances', $instance);
    }
}
