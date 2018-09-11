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
 * Class tool_fskandalis_api
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

/**
 * Class tool_fskandalis_api
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_fskandalis_api {

    /**
     * Delete a record
     *
     * @param $id
     */
    public static function delete($id) {
        global $DB;
        $DB->delete_records('tool_fskandalis', array('id' => $id));
    }

    /**
     * Insert a record
     *
     * @param stdClass $data
     * @return id of the new record
     */
    public static function insert(stdClass $data) {
        global $DB;

        $insertdata = array_intersect_key((array)$data,
            array('courseid' => 1, 'name' => 1, 'completed' => 1, 'priority' => 1));
        $insertdata['timemodified'] = $insertdata['timecreated'] = time();

        $recordid = $DB->insert_record('tool_fskandalis', $insertdata);
        if (isset($data->description_editor)) {
            $context = context_course::instance($data->courseid);
            $data = file_postupdate_standard_editor($data, 'description',
                self::editor_options(), $context, 'tool_fskandalis', 'record', $recordid);
            $updatedata = array('id' => $recordid, 'description' => $data->description,
                'descriptionformat' => $data->descriptionformat);
            $DB->update_record('tool_fskandalis', $updatedata);
        }
        return $recordid;
    }

    /**
     * Retrieve a record
     *
     * @param $id id of the record
     * @param $courseid optional course id for validation
     * @param $strictness
     * @return stdClass|bool retrieved object or false if record not found and strictness is IGNORE_MISSING
     * @throws dml_exception
     */
    public static function retrieve($id, $courseid = 0, $strictness = MUST_EXIST) {
        global $DB;
        $params = array('id' => $id);
        if ($courseid) {
            $params['courseid'] = $courseid;
        }
        return $DB->get_record('tool_fskandalis', $params, '*', $strictness);
    }

    /**
     * Options for the description editor
     * @return array
     */
    public static function editor_options() {
        global $PAGE;
        return [
            'maxfiles' => -1,
            'maxbytes' => 0,
            'context' => $PAGE->context,
            'noclean' => true,
        ];
    }

    /**
     * Update a record
     *
     * @param stdClass $data
     */
    public static function update(stdClass $data) {
        global $DB, $PAGE;

        if (isset($data->description_editor)) {
            $data = file_postupdate_standard_editor($data, 'description',
                self::editor_options(), $PAGE->context, 'tool_fskandalis', 'record', $data->id);
        }
        $updatedata = array_intersect_key((array)$data,
            array('id' => 1, 'name' => 1, 'completed' => 1, 'priority' => 1,
                'description' => 1, 'descriptionformat' => 1));
        $updatedata['timemodified'] = time();
        $DB->update_record('tool_fskandalis', $updatedata);
    }
}