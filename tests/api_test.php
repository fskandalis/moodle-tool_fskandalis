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
 * @group      tool_fskandalis
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tool_fskandalis_api_testcase extends advanced_testcase {

    /**
     * Set up for the tests.
     */
    public function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test for tool_fskandalis_api::delete
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

    public function test_description_editor() {
        $this->setAdminUser();
        $course = $this->getDataGenerator()->create_course();
        $recordid = tool_fskandalis_api::insert((object)array(
            'courseid' => $course->id,
            'name' => 'testname1',
            'description_editor' => array(
                'text' => 'some description',
                'format' => FORMAT_HTML,
                'itemid' => file_get_unused_draft_itemid()
            )
        ));
        $record = tool_fskandalis_api::retrieve($recordid);
        $this->assertEquals('some description', $record->description);

        tool_fskandalis_api::update((object)[
            'id' => $recordid,
            'name' => 'testname2',
            'description_editor' => [
                'text' => 'description edited',
                'format' => FORMAT_HTML,
                'itemid' => file_get_unused_draft_itemid()
            ]
        ]);
        $record = tool_fskandalis_api::retrieve($recordid);
        $this->assertEquals($course->id, $record->courseid);
        $this->assertEquals('testname2', $record->name);
        $this->assertEquals('description edited', $record->description);
    }
}