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
 * Plugin form
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class tool_fskandalis_form extends moodleform {

    public function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'name',
            get_string('name', 'tool_fskandalis'));
        $mform->setType('name', PARAM_NOTAGS);

        $mform->addElement('advcheckbox', 'completed',
            get_string('completed', 'tool_fskandalis'));

        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        if ($DB->record_exists_select('tool_fskandalis', 'name = :name AND id <> :id AND courseid = :courseid',
            ['name' => $data['name'], 'id' => $data['id'], 'courseid' => $data['courseid']])) {
            $errors['name'] = get_string('errornameexists', 'tool_fskandalis');
        }
        return $errors;
    }
}