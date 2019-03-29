<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
require_login();

ini_set('max_execution_time', 600);
ini_set('memory_limit', '2048M');
$idcategorie=0;
$url = new moodle_url('/local/up1_deploycohorts/index.php');
$PAGE->set_url($url);
$context = context_system::instance();;
$PAGE->set_context($context);
$PAGE->set_pagelayout('report');

$PAGE->requires->js(new moodle_url('/local/jquery/jquery.js'), true);
$PAGE->requires->js(new moodle_url('js/ajax.js'), true);  
$PAGE->requires->js(new moodle_url('/local/jquery/jquery-ui-1.8.22.custom.min.js'), true);
$PAGE->requires->css(new moodle_url('/local/jquery/css/ui-lightness/jquery-ui-1.8.22.custom.css'), true);
$PAGE->requires->css(new moodle_url('css/style.css'));
/**
 * vérification que l'utilisateur est un administrateur
 */

if (is_siteadmin()) {
	if (!empty($_POST['validation_ok'])) {
		insertionCohortes($_POST);
	}
	$annee = 0;	
    $PAGE->requires->js(new moodle_url('/local/jquery/jquery.js'), true);

	$PAGE->set_heading(get_string('heading_index', 'local_up1_deploycohorts'));
	$PAGE->set_title(get_string('title_index', 'local_up1_deploycohorts'));

	echo $OUTPUT->header();
	echo $OUTPUT->box_start('generalbox boxaligncenter boxwidthwide');
	
	$cats = getListeFatherCategories() ;
	$select = '<select name="select_1" id="select_1" onChange="ChangeSelectCategory(\'1\')"><option value="0" selected>--</option>';
	foreach($cats as $i=>$row) {
		$select .= '<option value="'.$row->id.'">'.$row->name.'</option>';
	}
	$libelle_choose_cat = get_string('choose_cat', 'local_up1_deploycohorts');
	$libelle_valider = get_string('ok', 'local_up1_deploycohorts');
	$select .= '</select>';
$form = <<< EOF
<a href="liste_cohorts_deployed.php">Aller à la liste des déploiements</a>
<form action="" method="GET" >
	<h3> $libelle_choose_cat $select <span id="span_1"></span></h3>
</form>
EOF;
	echo $form; // insertion du formulaire dans la page
	echo '<div id="result_1"></div>';
	echo '<div id="result_2"></div>';
	echo '<div id="result_3"></div>';
	echo '<div id="result_4"></div>';
	$listeRoles = getRoles();
	$select_role = '<select name="role" id="select_role"><option value="0" selected>--</option>';
	foreach($listeRoles as $i=>$row) {
		$select_role .= '<option value="'.$row->id.'">'.$row->name.'</option>';
	}	
	$select_role.='</select>';
	echo '
	<form id="form_validation" action="" method="POST">
	  	<input type="hidden" id="input_cohortes" name="cohortes" value="">
	  	<input type="hidden" id="input_cohortes_supprimees" name="cohortes_supprimees" value="">
	  	<input type="hidden" id="input_category" name="category" value="">
		<div class="ui-widget">
		  <label for="cohortes_search"><strong>Recherche de cohortes </strong></label>
		  <input id="cohortes_search" style="width:100%">
		</div>
		<div class="ui-widget" style="margin-top:2em; font-family:Arial">
		  <strong>Cohortes :</strong>
		  <div id="log" style="height: 200px;  overflow: auto;" class="ui-widget-content"></div>
		</div>	
		<div class="ui-widget" style="margin-top:2em; font-family:Arial">
		  <label for="role"><strong>Rôle</strong></label>
			'.$select_role.'
		</div>	
		<p style="float:right;padding-right:1em;"><input type="button" class="button-action" name="select_mail" value="valider" onclick="validation()();"></p><p style="clear:both"></p>
	</form>
	';
 
}
echo $OUTPUT->box_end();
echo $OUTPUT->footer(); 

echo '   
		<div class="focus" style="visibility: hidden;"></div>
		<div class="box-focus" id="box-focus" style="visibility: hidden;">
                <div id="pbox-title-focus">fgnfgn</div>
                <div id="pbox-focus"></div>
        </div>';
