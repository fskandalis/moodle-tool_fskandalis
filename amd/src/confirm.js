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
 * Add confirmation on delete
 *
 * @module     tool_fskandalis/confirm
 * @package    tool_fskandalis
 * @copyright  2018 Fotis Skandalis
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/str', 'core/notification', 'core/ajax', 'core/templates'],
    function($, str, notification, ajax, templates) {

        /**
         * Replaces the current list with the data rendered from template
         * @param {Object} data
         * @param {jQuery} list
         */
        var reloadList = function(data, list) {
            templates.render('tool_fskandalis/records_list', data).done(function(html) {
                list.replaceWith(html);
            });
        };

        /**
         * Processes deleting a record
         * @param {Number} id
         * @param {jQuery} list
         */
        var processDelete = function(id, list) {
            var courseid = list.attr('data-courseid');
            var requests = ajax.call([{
                methodname: 'tool_fskandalis_delete_record',
                args: {id: id}
            }, {
                methodname: 'tool_fskandalis_records_list',
                args: {courseid: courseid}
            }]);
            requests[1].done(function(data) {
                reloadList(data, list);
            }).fail(notification.exception);
        };

        /**
         * Displays the delete confirmation and on approval redirects to href
         * @param {Number} id
         * @param {jQuery} list
         */
        var confirmDelete = function(id, list) {
            str.get_strings([
                {key: 'delete'},
                {key: 'confirmdeleterecord', component: 'tool_fskandalis'},
                {key: 'yes'},
                {key: 'no'}
            ]).done(function(s) {
                    notification.confirm(s[0], s[1], s[2], s[3], function() {
                        processDelete(id, list);
                    });
                }
            ).fail(notification.exception);
        };

        /**
         * Registers the handler for click event
         * @param {String} selector
         */
        var registerClickHandler = function(selector) {
            $(selector).on('click', function(e) {
                e.preventDefault();
                var id = $(e.currentTarget).attr('data-recordid'),
                    list = $(e.currentTarget).closest('.tool_fskandalis_records_list');
                confirmDelete(id, list);
            });
        };

        return /** @alias module:tool_fskandalis/confirm */ {
            /**
             * Initialise the confirmation for selector
             *
             * @method init
             * @param {String} selector
             */
            init: function(selector) {
                registerClickHandler(selector);
            }
        };
});