<?php
// This file is part of a plugin for Moodle - http://moodle.org/

/**
 * @package    local
 * @subpackage crswizard
 * @copyright  2012-2013 Silecs {@link http://www.silecs.info/societe}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/* Cf documentation
http://docs.moodle.org/dev/NEWMODULE_Adding_capabilities
http://docs.moodle.org/dev/Hardening_new_Roles_system
 */

$capabilities = array(
    'local/up1_deploycohorts:deploy' => array(
        'riskbitmask'  => RISK_PERSONAL,
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => array(
            'manager'        => CAP_ALLOW
        ),
        'clonepermissionsfrom' => 'moodle/course:enrolreview'
    )
);
