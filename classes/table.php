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
 * Class tool_fskandalis_table
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/tablelib.php');

/**
 * Class tool_fskandalis_table for displaying tool_fskandalis table
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_fskandalis_table extends table_sql {

    public function __construct($uniqueid, $courseid) {
        global $PAGE;
        parent::__construct($uniqueid);
        $this->define_columns(array('name', 'completed', 'priority', 'timecreated', 'timemodified'));
        $this->define_headers(array(
            get_string('name', 'tool_fskandalis'),
            get_string('completed', 'tool_fskandalis'),
            get_string('priority', 'tool_fskandalis'),
            get_string('timecreated', 'tool_fskandalis'),
            get_string('timemodified', 'tool_fskandalis'),
        ));
        $this->pageable(true);
        $this->collapsible(false);
        $this->sortable(false);
        $this->is_downloadable(false);

        $this->define_baseurl($PAGE->url);

        $this->set_sql('name, completed, priority, timecreated, timemodified',
            '{tool_fskandalis}', 'courseid = ?', [$courseid]);
    }

    protected function col_completed($row) {
        return $row->completed ? get_string('yes') : get_string('no');
    }

    protected function col_priority($row) {
        return $row->priority ? get_string('yes') : get_string('no');
    }

    protected function col_name($row) {
        return format_string($row->name, true);
    }

    protected function col_timecreated($row) {
        return userdate($row->timecreated, get_string('strftimedatetime'));
    }

    protected function col_timemodified($row) {
        return userdate($row->timemodified, get_string('strftimedatetime'));
    }
}