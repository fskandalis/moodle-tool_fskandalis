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
 * Main file
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../config.php');

$id = required_param('id', PARAM_INT);

$url = new moodle_url('/admin/tool/fskandalis/index.php', array('id' => $id));

$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('helloworld', 'tool_fskandalis'));
$PAGE->set_heading(get_string('pluginname', 'tool_fskandalis'));


echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('helloworld', 'tool_fskandalis'));
echo html_writer::span(get_string('idpassed', 'tool_fskandalis', $id));
$user = $DB->get_record_sql("SELECT username, firstname, lastname FROM {user} WHERE username = ?", array('admin'));
echo html_writer::div(get_string('userinfo', 'tool_fskandalis', $user));
echo $OUTPUT->footer();