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
 * Plugin sttings page.
 *
 * @package    block
 * @subpackage eledia_course_trainerinfo
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    global $DB;

    require_once(dirname(__FILE__).'/locallib.php');

    $roles = get_roles_for_contextlevels(CONTEXT_COURSE);
    list($qrypart, $params_part) = $DB->get_in_or_equal($roles);
    $sql = "SELECT * FROM {role} WHERE id $qrypart";
    $roles = $DB->get_records_sql($sql, $params_part);
    $roles = role_fix_names($roles);
    $params = array();
    foreach ($roles as $role) {
        $params[$role->id] = $role->localname;
    }

    $settings->add(new admin_setting_configselect('block_eledia_trainerinfo_role_course',
        get_string('configure_eledia_trainerinfo_role_course_title', 'block_eledia_trainerinfo'),
        get_string('configure_eledia_trainerinfo_role_course', 'block_eledia_trainerinfo'),
                0,
                $params));

    // Settings for what fields should be shown.
    $settings->add(new admin_setting_heading('block_eledia_trainerinfo_settings_h1',
                    get_string('viewablefields', 'block_eledia_trainerinfo'),
                    ''));

    $showablefields = explode(',', BLOCK_ELEDIA_TRAINERINFO_SHOWABLE_FIELDS);

    foreach ($showablefields as $sf) {
        // Showing this field?
        $settings->add(new admin_setting_configcheckbox('block_eledia_trainerinfo/showfield_'.$sf,
                                    get_string($sf),
                                    '',
                                    true));
    }
}
