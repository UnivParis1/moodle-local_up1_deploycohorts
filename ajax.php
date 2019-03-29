<?php 
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once('../../lib/accesslib.php');
require_once('locallib.php');
if (is_siteadmin()) {
	if (isset($_REQUEST['idcat'])) $categorie = $_REQUEST['idcat']; else $categorie = 0;
	if (isset($_REQUEST['typecat'])) $typecat = $_REQUEST['typecat'] +1; else $typecat = 2;
	$cats = getListeCategoriesByFather($categorie) ;
	$select = '<select name="categories" id="select_'.$typecat.'"  onChange="ChangeSelectCategory(\''.$typecat.'\')">';
	if ($categorie == 0) $select .= '<option value="0" selected>--</option>'; else $select .= '<option value="0">--</option>';
	foreach($cats as $i=>$row) {
		$select .= '<option value="'.$row->id.'">'.$row->name.'</option>';
	}
	$libelle_choose_cat = get_string('choose_cat', 'local_up1_deploycohorts');
	$libelle_valider = get_string('ok', 'local_up1_deploycohorts');
	$select .= '</select>';
	$form = <<< EOF
<form action="index.php" method="GET" >
	<h4> $libelle_choose_cat $select <span id="span_$typecat"></span></h4>
</form>
EOF;
if (!empty($cats))
	echo $form;
}
?>