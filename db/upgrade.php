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
 * tool_fskandalis upgrade script.
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Run all upgrade steps between the current DB version and the current version on disk.
 *
 * @param int $oldversion The old version of atto equation in the DB.
 * @return bool
 */
function xmldb_tool_fskandalis_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2018090503) {

        // Define table tool_fskandalis to be created.
        $table = new xmldb_table('tool_fskandalis');

        // Adding fields to table tool_fskandalis.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('completed', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('priority', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');
        $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', null, null, null, null);
        $table->add_field('timemodified', XMLDB_TYPE_INTEGER, '10', null, null, null, null);

        // Adding keys to table tool_fskandalis.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for tool_fskandalis.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Fskandalis savepoint reached.
        upgrade_plugin_savepoint(true, 2018090503, 'tool', 'fskandalis');
    }

    if ($oldversion < 2018090504) {

        // Define key courseid (foreign) to be added to tool_fskandalis.
        $table = new xmldb_table('tool_fskandalis');
        $key = new xmldb_key('courseid', XMLDB_KEY_FOREIGN, array('courseid'), 'course', array('id'));
        $index = new xmldb_index('courseidname', XMLDB_INDEX_UNIQUE, array('courseid', 'name'));

        // Launch add key courseid.
        $dbman->add_key($table, $key);

        // Conditionally launch add index courseidname.
        if (!$dbman->index_exists($table, $index)) {
            $dbman->add_index($table, $index);
        }

        // Fskandalis savepoint reached.
        upgrade_plugin_savepoint(true, 2018090504, 'tool', 'fskandalis');
    }

    if ($oldversion < 2018091102) {

        // Define field description to be added to tool_fskandalis.
        $table = new xmldb_table('tool_fskandalis');
        $field = new xmldb_field('description', XMLDB_TYPE_TEXT, null, null, null, null, null, 'timemodified');
        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }
        // Define field descriptionformat to be added to tool_fskandalis.
        $field = new xmldb_field('descriptionformat', XMLDB_TYPE_INTEGER, '10', null, null, null, null, 'description');
        // Conditionally launch add field description.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Fskandalis savepoint reached.
        upgrade_plugin_savepoint(true, 2018091102, 'tool', 'fskandalis');
    }

    return true;
}