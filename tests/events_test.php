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
 * This file contains the class that handles testing of tool events.
 *
 * @package tool_fskandalis
 * @copyright  2016 Stephen Bourget
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class tool_fskandalis_events_testcase extends advanced_testcase {

    /**
     * Tests set up
     */
    protected function setUp() {
        $this->resetAfterTest();
    }

    /**
     * Test for event record_created
     */
    public function test_record_created() {
        $course = $this->getDataGenerator()->create_course();
        $sink = $this->redirectEvents();
        $recordid = tool_fskandalis_api::insert((object)array(
            'courseid' => $course->id,
            'name' => 'testname1',
            'completed' => 1,
            'priority' => 0,
        ));
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = array_shift($events);
        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\tool_fskandalis\event\record_created', $event);
        $this->assertEquals($course->id, $event->courseid);
        $this->assertEquals($recordid, $event->objectid);
    }
    /**
     * Test for event record_updated
     */
    public function test_record_updated() {
        $course = $this->getDataGenerator()->create_course();
        $recordid = tool_fskandalis_api::insert((object)array(
            'courseid' => $course->id,
            'name' => 'testname1'
        ));
        $sink = $this->redirectEvents();
        tool_fskandalis_api::update((object)array(
            'id' => $recordid,
            'name' => 'testname2',
        ));
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = array_shift($events);
        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\tool_fskandalis\event\record_updated', $event);
        $this->assertEquals($course->id, $event->courseid);
        $this->assertEquals($recordid, $event->objectid);
    }
    /**
     * Test for event record_deleted
     */
    public function test_entry_deleted() {
        $course = $this->getDataGenerator()->create_course();
        $recordid = tool_fskandalis_api::insert((object)array(
            'courseid' => $course->id,
            'name' => 'testname1'
        ));
        $sink = $this->redirectEvents();
        tool_fskandalis_api::delete($recordid);
        $events = $sink->get_events();
        $this->assertCount(1, $events);
        $event = array_shift($events);
        // Checking that the event contains the expected values.
        $this->assertInstanceOf('\tool_fskandalis\event\record_deleted', $event);
        $this->assertEquals($course->id, $event->courseid);
        $this->assertEquals($recordid, $event->objectid);
    }
}