<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
if (is_siteadmin()) {
	$listecours = array();
	echo '<div style="width:500px;display:block;margin:1em auto;">'; 
	echo '<h3>Récapitulatif</h3>';
	$form = '<form action="index.php" method="POST">';
	$form .= '<input type="hidden" name="validation_ok" value="OK">';
	if (!empty($_POST['category'])) {
		echo '<p> <strong> Catégorie principale : </strong> '.getPathNameById($_POST['category']).'</p>';
		$form .= '<input type="hidden" name="category" value="'.$_POST['category'].'">';
		$listecours = getListeEPI($_POST['category']);
	}
	if (!empty($_POST['cohortes'])) {
		$cohortes = explode('/', $_POST['cohortes']);
		if (!empty($_POST['cohortes_supprimees'])) {
			$cohortes_a_supprimer = explode('/', $_POST['cohortes_supprimees']);
			$form .= '<input type="hidden" name="cohortes_supprimees" value="'.$_POST['cohortes_supprimees'].'">';
		} else 
		{
			$cohortes_a_supprimer = array();
		$form .= '<input type="hidden" name="cohortes_supprimees" value="">';
		}
		$ulli = '<ul>';
		foreach ($cohortes as $cle=>$val) {
			if (!in_array($val, $cohortes_a_supprimer)&&!empty($val)) $ulli.='<li>'.getNameElement('cohort',$val).'</li>';
		}
		$ulli .= '</ul>';
		echo '<p> <strong> Cohortes : </strong> '.$ulli.'</p>';
		$form .= '<input type="hidden" name="cohortes" value="'.$_POST['cohortes'].'">';
	}
		
	if (!empty($_POST['role'])) {
		echo '<p> <strong> Role : </strong> '.getNameElement('role',$_POST['role']).'</p>';
		$form .= '<input type="hidden" name="role" value="'.$_POST['role'].'">';
	}
	echo $form;
	echo '<p style="float:right;padding-right:1em;">
			<input type="button" class="button-action" name="Annulation" value="annuler" onclick="closebox();">&nbsp;&nbsp;&nbsp;
			<input type="submit" class="button-action" name="validation" value="valider" >
		</p>
		<p style="clear:both"></p></form>';
	if (!empty($listecours)) {
		
		$table = new html_table();
		$table->head = array('Id du cours','Liste des EPI concernés');
		$table->data = $listecours;
		
		echo '<h3>Liste des EPI concernés</h3>';
		echo html_writer::table($table);		
	}
	echo '</div>';
}
?>