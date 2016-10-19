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
 * Block Definition. The Block contains information about the course trainers.
 *
 * @package    block
 * @subpackage eledia_course_trainerinfo
 * @author     Benjamin Wolf <support@eledia.de>
 * @copyright  2013 eLeDia GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_eledia_trainerinfo extends block_base {
    /**
     * block initializations
     */
    public function init() {
        $this->title   = get_string('pluginname', 'block_eledia_trainerinfo');
        $this->cfg = get_config('block_eledia_trainerinfo');
    }

    /**
     * locations where block can be displayed
     *
     * @return array
     */
    public function applicable_formats() {
        return array('course' => true);
    }

    /**
     * block contents
     *
     * @return object
     */
    public function get_content() {
        global $CFG, $USER, $DB, $OUTPUT, $PAGE;

        require_once(dirname(__FILE__).'/locallib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        // Get course user with choosen role.
        $course = $this->page->course;
        $context = context_course::instance($course->id);
        $user_enrolments = $DB->get_records('role_assignments',
                array('roleid' => $CFG->block_eledia_trainerinfo_role_course,
                    'contextid' => $context->id));
        if (!empty($user_enrolments)) {
            $userlist = array();
            foreach ($user_enrolments as $user_enrolment) {
                $userlist[] = $DB->get_record('user', array('id' => $user_enrolment->userid));
            }
        }

        // Loop through user list.
        if (!empty($userlist)) {
            foreach ($userlist as $user) {

                if (!isset($this->config->display_picture) || $this->config->display_picture == 1) {
                    $this->content->text .= $OUTPUT->user_picture($user,
                            array('courseid' => $course->id,
                                'size' => '100',
                                'class' => 'profilepicture',
                                'float' => 'none'));  // The new class makes CSS easier , 'align' => 'center'.

                }
                $this->content->text .= '<div class="userinfo">';
                $this->content->text .= '<strong>'.$user->firstname.' '.$user->lastname.'</strong><br />';
                $showablefields = explode(',', BLOCK_ELEDIA_TRAINERINFO_SHOWABLE_FIELDS);
                foreach ($showablefields as $sf) {
                    if(!empty($this->cfg->{'showfield_'.$sf}) AND $user->{$sf}){
                        if ($sf == 'email') {
                            $this->content->text .= '<a href="mailto:'.
                                    $user->email.
                                    '" target="_blank">'.
                                    get_string('mailstring', 'block_eledia_trainerinfo').
                                    '</a><br />';
                        } else {
                            $this->content->text .= $user->{$sf}.'<br />';
                        }
                    }
                }
                $this->content->text .= '<hr>';
                $this->content->text .= '</div>';
            }
        }
        return $this->content;
    }

    /**
     * allow the block to have a configuration page
     *
     * @return boolean
     */
    public function has_config() {
        return true;
    }
}
