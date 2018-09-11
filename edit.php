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
 * Plugin edit
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../../config.php');

require_once($CFG->dirroot.'/admin/tool/fskandalis/lib.php');

$id = optional_param('id', 0, PARAM_INT);
$deleteid = optional_param('delete', null, PARAM_INT);

if ($id) {
    $record = $DB->get_record('tool_fskandalis', array('id' => $id), '*', MUST_EXIST);
    $courseid = $record->courseid;
    $title = get_string('editrecord', 'tool_fskandalis');
    $params = array('id' => $id);
} else {
    // We are going to add an
    $courseid = required_param('courseid', PARAM_INT);
    $record = (object)array('courseid' => $courseid);
    $title = get_string('newrecord', 'tool_fskandalis');
    $params = array('courseid' => $courseid);
}

$url = new moodle_url('/admin/tool/fskandalis/edit.php', $params);
$PAGE->set_url($url);

require_login($courseid);
$context = context_course::instance($courseid);
require_capability('tool/fskandalis:edit', $context);

$PAGE->set_title($title);
$PAGE->set_heading(get_string('pluginname', 'tool_fskandalis'));

// take care of deleting an entry
if ($deleteid) {
    require_sesskey();
    $record = $DB->get_record('tool_fskandalis', array('id' => $deleteid, 'courseid' => $courseid),
        '*', MUST_EXIST);
    require_capability('tool/fskandalis:edit', $context);
    $DB->delete_records('tool_fskandalis', array('id' => $deleteid));
    redirect(new moodle_url('/admin/tool/fskandalis/index.php', array('id' => $courseid)));
}

$form = new tool_fskandalis_form();
if (!empty($record->id)) {
    file_prepare_standard_editor($record, 'description',
        tool_fskandalis_api::editor_options($courseid),
        $PAGE->context, 'tool_fskandalis', 'record', $record->id);
}
$form->set_data($record);

$returnurl = new moodle_url('/admin/tool/fskandalis/index.php', array('id' => $courseid));

if ($form->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $form->get_data()) {
    if ($data->id) {
        tool_fskandalis_api::update($data);
    } else {
        tool_fskandalis_api::insert($data);
    }
    redirect($returnurl);
}
echo $OUTPUT->header();
$form->display();
echo $OUTPUT->footer();