<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Installation process of the plugin.
 *
 * @package    block
 * @subpackage eledia_course_trainerinfo
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function xmldb_block_eledia_trainerinfo_install() {
    global $DB;

    // Find and get old block instances.
    $old_instances = $DB->get_records('block_instances', array('blockname' => 'eledia_referenten'));
    foreach ($old_instances as $instance) {
        $instance->blockname = 'eledia_trainerinfo';
        $DB->update_record('block_instances', $instance);
    }

    $config = get_config('core', 'block_eledia_referenten_role_course');
    set_config('block_eledia_trainerinfo_role_course', $config);
}
