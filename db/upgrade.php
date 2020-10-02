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
 * This file keeps track of upgrades to the poodlltime module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_poodlltime
 * @copyright  2015 Justin Hunt (poodllsupport@gmail.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use \mod_poodlltime\constants;

/**
 * Execute poodlltime upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_poodlltime_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager(); // loads ddl manager and xmldb classes



    // Add question titles to poodlltime table
    if ($oldversion < 2020090700) {
        $activitytable = new xmldb_table(constants::M_TABLE);


        // Define field showqtitles to be added to poodlltime\
        $showqtitles= new xmldb_field('showqtitles', XMLDB_TYPE_INTEGER, '2', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, '1');

        // add showqtitles field to poodlltime table
        if (!$dbman->field_exists($activitytable, $showqtitles)) {
            $dbman->add_field($activitytable, $showqtitles);
        }
        upgrade_mod_savepoint(true, 2020090700, 'poodlltime');
    }

    // Add passagehash to questions table
    if ($oldversion < 2020100200) {
        $qtable = new xmldb_table(constants::M_QTABLE);


        // Define field showqtitles to be added to poodlltime\
        $field = new xmldb_field('passagehash', XMLDB_TYPE_CHAR, '255', XMLDB_UNSIGNED, XMLDB_NOTNULL, null);

        // add showqtitles field to poodlltime table
        if (!$dbman->field_exists($qtable, $field)) {
            $dbman->add_field($qtable, $field);
        }
        upgrade_mod_savepoint(true, 2020100200, 'poodlltime');
    }





    // Final return of upgrade result (true, all went good) to Moodle.
    return true;
}
