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

require_login($id);
$context = context_course::instance($id);
require_capability('tool/fskandalis:view', $context);

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('report');
$PAGE->set_title(get_string('helloworld', 'tool_fskandalis'));
$PAGE->set_heading(get_string('pluginname', 'tool_fskandalis'));

$outputpage = new \tool_fskandalis\output\records_list($id);
$output = $PAGE->get_renderer('tool_fskandalis');
echo $output->header();
echo $output->render($outputpage);
echo $output->footer();