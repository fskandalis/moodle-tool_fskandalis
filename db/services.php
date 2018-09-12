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
 * Web services for tool_fskandalis
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = array(
    'tool_fskandalis_delete_record' => array(
        'classname'    => 'tool_fskandalis_external',
        'methodname'   => 'delete_record',
        'description'  => 'Deletes a record',
        'type'         => 'write',
        'capabilities' => 'tool/fskandalis:edit',
        'ajax'         => true,
    ),
    'tool_fskandalis_records_list' => array(
        'classname'    => 'tool_fskandalis_external',
        'methodname'   => 'records_list',
        'description'  => 'Returns list of records',
        'type'         => 'read',
        'capabilities' => 'tool/fskandalis:view',
        'ajax'         => true,
    ),
);