<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
require_login();

ini_set('max_execution_time', 600);
ini_set('memory_limit', '2048M');
$idcategorie=0;
$url = new moodle_url('/local/up1_deploycohorts/liste_cohorts_deployed.php');
$PAGE->set_url($url);
$context = context_system::instance();;
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');
$PAGE->requires->js(new moodle_url('/local/jquery/jquery.js'), true);
$PAGE->requires->js(new moodle_url('js/ajax.js'), true);  
$PAGE->requires->js(new moodle_url('/local/jquery/jquery-ui-1.8.22.custom.min.js'), true);
$PAGE->requires->css(new moodle_url('/local/jquery/css/ui-lightness/jquery-ui-1.8.22.custom.css'), true);
$PAGE->requires->css(new moodle_url('css/style.css'));
	
$PAGE->set_heading(get_string('heading_index', 'local_up1_deploycohorts'));
$PAGE->set_title(get_string('title_index', 'local_up1_deploycohorts'));
/**
 * vérification que l'utilisateur est un administrateur
 */
echo $OUTPUT->header();
echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthwide');
if (is_siteadmin()) {
		$listeLiaison = getListeLiaison();
		$table = new html_table();
		$table->head = array(
							'Id ',
							'Nom de la categorie',
                                                        'Liste des cohortes',
							'Nom du rôle',
							'Date de déploiement',
							'Auteur du déploiement',
							'Suppression');
		$table->data = $listeLiaison;
		echo '<div id="result">';
		echo '<h3>Liste des déploiements effectués</h3>';
		echo '<a href="index.php">Déployer des cohortes</a>';
		echo html_writer::table($table);	
		echo '</div>';
 
}
echo $OUTPUT->box_end();
echo $OUTPUT->footer(); 
echo '   
	<div class="focus" style="visibility: hidden;"></div>
	<div class="box-focus" id="box-focus" style="visibility: hidden;">
		<div id="pbox-title-focus">fgnfgn</div>
		<div id="pbox-focus"></div>
	</div>';
