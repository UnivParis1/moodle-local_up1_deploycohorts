<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
if (is_siteadmin()) {
	if (!empty($_REQUEST['term']))
		$listcohortes = getCohortesLikeTerm($_REQUEST['term']);
		echo json_encode($listcohortes);
}
?>