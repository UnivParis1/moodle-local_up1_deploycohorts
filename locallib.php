<?php
/**
 * @author 		El-Miqui CHEMLALI <el-miqui.chemlali@univ-paris1.fr>
 * @package    	local
 * @subpackage 	up1_deploycohorts
 */

global $CFG;
/**
 * 
 * Retourne les pères de toutes les catégories
 * @return array 
 */
function getListeFatherCategories() {
	global $DB;
	$SELECT = "	SELECT * FROM {course_categories} where parent=0 order by name";
	$listeFathers= $DB->get_records_sql($SELECT);
    return $listeFathers;
}
/**
 * 
 * Retourne les fils de la catégorie $idcat
 * @param $idcat int identifiant de la catégorie
 * @return array 
 */
function getListeCategoriesByFather($idcat) {
	global $DB;
	$SELECT = "	SELECT * FROM {course_categories} where parent=? order by name";
	$listeCategories= $DB->get_records_sql($SELECT,array($idcat));
    return $listeCategories;
}

/**
 * 
 * Retourne l'ensemble des cours d'une catégorie et de ces sous-catégorie
 * @param integer $id_categorie
 * @return array 
 */
function getListeEpiFromCategory($id_categorie) {
	global $DB;
	$SELECT = "	SELECT C.id, C.fullname
        	FROM {course} C 
        	INNER JOIN {course_categories} CC on ( C.category =  CC.id) 
        	WHERE (CC.path LIKE ? OR CC.path LIKE ?  )";
	echo $SELECT;
	$listeEPI= $DB->get_record_sql($SELECT, array('%/'.$id_categorie.'/%','%/'.$id_categorie));
    return $listeEPI;
}

/**
 * 
 * Retourne l'ensemble des cohortes manuelles contenant le terme $term
 * @param integer $term
 * @return array 
 */

function getCohortesLikeTerm($term) {
	global $DB;
	$SELECT = "	SELECT C.id, C.name
        	FROM {cohort} C 
        	WHERE C.name like ? and C.component !='local_cohortsyncup1' and  C.component !='local_cohortsyncup1_2012' order by C.name";
	$obj= $DB->get_records_sql($SELECT, array('%'.$term.'%'));
	$listeCohortes = array();
	foreach($obj as $i=> $cohorte) {
		$listeCohortes[] = array(
							'id' => $cohorte->id,
							'label' => $cohorte->name,
							'value' => $cohorte->name
								);
	}
	
    return $listeCohortes;
}



/**
 * 
 * Retourne l'ensemble des cohortes manuelles contenant le terme $term
 * @param integer $term
 * @return array 
 */
function getMembersCohort($cohortid) {
	global $DB;
	$SELECT = "	SELECT userid
        	FROM {cohort_members} C 
        	WHERE cohortid = ?";
	$obj= $DB->get_records_sql($SELECT, array($cohortid));
	$members = array();
	foreach($obj as $i=> $row) {
		$members[] = $row->userid
	}
	
    return $members;
}


/**
 * 
 * Retourne l'ensemble des rôles ou le rôle ayant pour identifiant $idrole
 * @param integer $idrole
 * @return array 
 */

function getRoles($idrole = 0) {
	global $DB;
	$SELECT = "	SELECT R.id, R.name
        	FROM {role} R ";
	if (!empty($idrole)) {
		$SELECT .= "	WHERE R.id = ? order by R.sortorder";
		$obj= $DB->get_record_sql($SELECT, array($idrole));
		if (!empty($obj->id)&&!empty($obj->name)) return  array('id'=>$obj->id,'name'=>$obj->name);
		return null;
	} else {
		$SELECT .= " order by R.sortorder";
		$obj= $DB->get_records_sql($SELECT, array());
		return $obj;
	}
    return null;
}




/**
 * 
 * Retourne lechemin de la catégorie via l'identifiant
 * @param integer $id
 * @return string 
 */
function getPathNameById($id) {
	global $DB;
	$SELECT = "	SELECT path FROM {course_categories} where id=?";
	$obj= $DB->get_record_sql($SELECT,array($id));
    if (!empty($obj->path))  {
    	$cpt = 1;
    	$path_return = '';
    	$path = explode('/', $obj->path);
    	foreach( $path as $cle => $val) {
    		if (!empty($val)) {
        		if ($cpt == 1 ) 
    			$path_return = getNameElement('course_categories',$val);
	    		else 
	    			$path_return .=  ' > ' .getNameElement('course_categories',$val);
	    		$cpt++;			
    		}

    	}
    	return $path_return;
    }
    return null;
}



/**
 * 
 * Retourne le nom de l'élément de la table $table
 * @param integer $id
 * @param string $table
 * @return string 
 */
function getNameElement($table,$id) {
	global $DB;
	$SELECT = "	SELECT name FROM {".$table."} where id=?";
	$obj= $DB->get_record_sql($SELECT,array($id));
    if (!empty($obj->name)) return $obj->name;
    return null;
}


/**
 * 
 * Retourne la liste des EPI de la catégorie $id
 * @param integer $idcat
 * @return string 
 */
function getListeEPI($id) {
	global $DB;
	$array_EPI = array();
	$SELECT = "	SELECT distinct C.id, C.fullname FROM {course} C 
        	INNER JOIN {course_categories} CC on ( C.category =  CC.id) 
        	WHERE (CC.path LIKE ? OR CC.path LIKE ? )
        	ORDER BY C.fullname";
	$obj= $DB->get_records_sql($SELECT,array('%/'.$id.'/%','%/'.$id));
	foreach ($obj as $cle=>$EPI) {
		$array_EPI[] = array($EPI->id,$EPI->fullname);
	}
    return $array_EPI;
}

function getNameUser($userid) {
	global $DB;
	$SELECT = "	SELECT CONCAT(firstname, ' ', lastname) as nom  FROM {user} where id=?";
	$obj= $DB->get_record_sql($SELECT,array($userid));
    if (!empty($obj->nom)) return $obj->nom;
    return null;
}

function getNameCohorte($id) {
        global $DB;
        $SELECT = "     SELECT  name  FROM {cohort} where id=?";
        $obj= $DB->get_record_sql($SELECT,array($id));
    if (!empty($obj->name)) return $obj->name;
    return null;
}

/**
 * 
 * Formare une variable datetime en date lisible
 * @param datetime $date_a_formater
 */

function formaterDate($date_a_formater) {
	$tab_month = array(1=>"Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
	$tab_day = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");
	$prefix = "";
	$suffix = " à";
	$tab_date = explode(' ', $date_a_formater);
	$date_hour = explode(':', $tab_date[1]);
	$tab_dmy = explode('-', $tab_date[0]);
	$day = date("w", mktime(0, 0, 0, $tab_dmy[1], $tab_dmy[2], $tab_dmy[0]));
	$date_formatee = $prefix . "$tab_day[$day] " . "$tab_dmy[2] ";
	settype($tab_dmy[1], 'integer');
	$date_formatee .= $tab_month[$tab_dmy[1]] . " $tab_dmy[0]" . $suffix . " $date_hour[0]h " . "$date_hour[1]min";
	return $date_formatee;
}


/**
 * Transforme la liste de cohortes en html 
 * @param string liste_cohortes
 * @return string 
 */

function transformCohortes($listecohortes) {
        $retour = '';
        $arr_cohortes = explode(',',$listecohortes);
	for ($i=0;$i<count($arr_cohortes);$i++) {
            $retour .= '<a title="'.getNameCohorte($arr_cohortes[$i]).'">'.$arr_cohortes[$i].'</a> ,';
	}
        return $retour;
}


/**
 * 
 * Retourne la liste des Liaison Cohortes/categories déployées
 * @param integer $id_laison
 * @return array 
 */
function getListeLiaison() {
	global $DB;
	$array_liaison = array();
	$SELECT = "	SELECT CDH.id, R.name as nom_role, CDH.category , CDH.date_deploiement, CDH.userid, CDH.id_de_cohortes 
				FROM {cohort_deployed_history} as CDH
				INNER JOIN {role} as R ON (R.id=CDH.role)";
	$obj= $DB->get_records_sql($SELECT,array());
	foreach ($obj as $cle=>$LIAISON) {
		$array_liaison[] = array(	$LIAISON->id,
									getPathNameById($LIAISON->category),
                                                                        transformCohortes($LIAISON->id_de_cohortes),
									$LIAISON->nom_role,
									formaterDate($LIAISON->date_deploiement),
									getNameUser($LIAISON->userid),
									'<a href="javascript:supprimerLiaison(\''.$LIAISON->id.'\')"><img src="img/supprimer.gif"></a>'
								);
	}
    return $array_liaison;
}

/**
 * 
 * Enrollement de la lisaison cohorte/EPI 
 * @param array $formdata
 */
function insertionCohortes($formdata) {
	global $DB,$USER;
		$listecours = array();
	if (!empty($formdata['category']) && 
			!empty($formdata['cohortes']) && 
					!empty($formdata['role'])) {
		$listecours = getListeEPI($formdata['category']);
		$cohortes = explode('/', $formdata['cohortes']);
		$cohortes_a_supprimer = explode('/', $formdata['cohortes_supprimees']);
		$role = $formdata['role'];
		$cpt = 1;
		$enrol_ids = '';
		$id_de_cohortes = '';
		$id_de_cours = '';
		$category = $formdata['category'];
		foreach($listecours as $i=>$EPI) {
			foreach($cohortes as $j=>$cohorte) {
				if (!in_array($cohorte, $cohortes_a_supprimer) && !empty($cohorte)) {
					$dataobject_enrol = new stdClass();
					$dataobject_enrol->enrol = 'cohort';
					$dataobject_enrol->courseid = $EPI[0];
					$dataobject_enrol->customint1 = $cohorte;
					$dataobject_enrol->roleid = $role;
    				$last_insert_id = $DB->insert_record('enrol', $dataobject_enrol);
    				if ($cpt == 1) {
    					$enrol_ids = $last_insert_id;
    					$id_de_cohortes = $cohorte;
    					$id_de_cours = $EPI[0];
    				} else {
    					
    					$enrol_ids 		.= ','.$last_insert_id;
    					$id_de_cohortes .= ','.$cohorte;
    					$id_de_cours 	.= ','.$EPI[0];
    				}
    				$members = getMembersCohort($cohorte);
    				for($z=0;$z<count($members);$z++) {
    					$INSERT = "INSERT INTO {user_enrolments} 
    								(enrolid,userid) 
    								VALUES ($last_insert_id,".$members[$z].")";
						$DB->execute($INSERT);

    				}

    				$cpt ++;
				}
			}
		}
		$INSERT =  "INSERT INTO {cohort_deployed_history} 
						(category, role,userid, enrol_ids, id_de_cohortes, id_de_cours, date_deploiement )  
					VALUES ($category,$role,$USER->id,'$enrol_ids','$id_de_cohortes','$id_de_cours',NOW())";
		$DB->execute($INSERT);
	}
}
/**
 * Retourne la liste des id de la table enrol correspondant à une liaison effectuée
 * @param int $id
 * @return string
 */
function getEnrolids($id) {
	global $DB;
	$SELECT = "	SELECT enrol_ids FROM {cohort_deployed_history} where id=?";
	$obj= $DB->get_record_sql($SELECT,array($id));
	if (!empty($obj->enrol_ids)) return $obj->enrol_ids;
	return '';
}

function getRoleAndCourseAndCohort($id){
	global $DB;
        $SELECT = "     SELECT role, id_de_cours,id_de_cohortes  FROM {cohort_deployed_history} where id=?";
        $obj= $DB->get_record_sql($SELECT,array($id));
        if (!empty($obj->role)) return array($obj->role,$obj->id_de_cours,$obj->id_de_cohortes);
        return array(0,'','');
}


/**
 * 
 * Suppression de la lisaison cohorte/EPI 
 * @param int $id_liaison 
 */
function supprimer_liaison($id_liaison) {
	global $DB;
	$enrol_ids = getEnrolids($id_liaison);
	if (!empty($enrol_ids)) {
		$DELETE_ENROLS = "DELETE FROM {enrol} where id in ($enrol_ids)";
		$DB->execute($DELETE_ENROLS);
		$DELETE_HISTORY = "DELETE FROM {cohort_deployed_history} where id = $id_liaison";
		$DB->execute($DELETE_HISTORY);
	}
}
