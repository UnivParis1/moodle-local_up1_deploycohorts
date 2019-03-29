<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
if (is_siteadmin()) {
	if (!empty($_POST['id'])) {
		supprimer_liaison($_POST['id']);
	}
	
		$listeLiaison = getListeLiaison();
		$table = new html_table();
		$table->head = array(
							'Id ',
							'Nom de la categorie',
							'Nom du rôle',
							'Date de déploiement',
							'Suppression');
		$table->data = $listeLiaison;
		
		echo '<h3>Liste des déploiements effectués</h3>';
		echo '<a href="index.php">Déployer des cohortes</a>';
		echo html_writer::table($table);	
 
}
?>