<?php

/**
 * Settings and links
 *
 * @package    local
 * @subpackage up1_deploycohorts
 * @author 		El-Miqui CHEMLALI
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;
if (has_capability('moodle/site:config', context_system::instance())) {
    $ADMIN->add('reports',
        new admin_externalpage('local_up1_deploycohorts',
                 get_string('pluginname', 'local_up1_deploycohorts'),
                "$CFG->wwwroot/local/up1_deploycohorts/liste_cohorts_deployed.php")
        );
}
