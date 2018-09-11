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
 * API tests.
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * API tests.
 *
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_fskandalis_api_testcase extends advanced_testcase {

    /**
     * Set up for the tests.
     * @group      tool_fskandalis
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test for tool_fskandalis_api::delete
     * @group      tool_fskandalis
     */
    public function test_delete() {
        $course = $this->getDataGenerator()->create_course();
        $recordid = tool_fskandalis_api::insert((object)array(
            'courseid' => $course->id,
            'name' => 'testname1'
        ));
        tool_fskandalis_api::delete($recordid);
        $entry = tool_fskandalis_api::retrieve($recordid, 0, IGNORE_MISSING);
        $this->assertEmpty($entry);
    }
}