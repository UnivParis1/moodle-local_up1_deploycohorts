  $(function() {
    function log( message ) {
      $( "<div>" ).text( message ).prependTo( "#log" );
      $( "#log" ).scrollTop( 0 );
    }
 
    $( "#cohortes_search" ).autocomplete({
      source: "search.php",
      minLength: 2,
      select: function( event, ui ) {
    	log_cohortes = $("#log").html();
    	p_cohorte = '<p id="p_cohorte_' + ui.item.id +'"><a href="javascript:SupprimerCohorte(\''+ ui.item.id +'\')"> <img src="img/delete_small.png"></a>&nbsp;&nbsp;&nbsp;' + ui.item.value + '</p>';
    	$("#log").html(p_cohorte+log_cohortes);
      /*
    	log( ui.item ?
          '<p id="span_cohorte_' + ui.item.value +'">Selected: ' + ui.item.value + 
          				'<a href="SupprimerCohorte(\''+ ui.item.value +'\'"><img src="img/delete_small.png"></a> </p>':
        	  "Nothing selected, input was " + this.value );
        */
    	cohortes =  $( "#input_cohortes" ).val();
        $( "#input_cohortes" ).val(cohortes+'/'+ui.item.id);
        $( "#cohortes_search" ).val(' ');
      }
    });
  });
function ChangeSelectCategory(typecat,idcat) {
	$('#span_'+typecat).html('<img src="img/ajax-loader5.gif" width="16">');
	idcat = $("#select_"+typecat).val();
	$.ajax({
	    type: "POST",
	    url: "ajax.php",
	    data : '&typecat='+typecat+'&idcat='+idcat,
	    success:
	    function(retour){
	    	$('#result_'+typecat).html(retour);
	    	$('#span_'+typecat).html('<img src="img/status-active.png" width="16">');
	    	$('#input_category').val(idcat);
	    }
	});	
}

function SupprimerCohorte(idcohorte) {
	$('#p_cohorte_'+idcohorte).hide();
    cohortes_a_supprimer =  $( "#input_cohortes_supprimees" ).val();
	$( "#input_cohortes_supprimees" ).val(cohortes_a_supprimer+'/'+idcohorte);
}

function validation() {
	$.ajax({
	    type: "POST",
	    url: "validation.php",
	    data : $("#form_validation").serialize(),
	    success:
	    function(retour){
	    	$("#pbox-title-focus").html('Récapitulatif');
	    	$("#pbox-focus").html(retour).fadeIn();
	        $('#box-focus').css('visibility', 'visible');
	        $('.focus').css('visibility', 'visible');
	        $('html,body').animate({scrollTop: $("#box-focus").offset().top}, 'slow');
	    }
	});	
}

function closebox() {
	$('#box-focus').css('visibility', 'hidden');
	$('.focus').css('visibility', 'hidden');
}

function supprimerLiaison(id) {
	if (confirm('Etes-vous sûr de vouloir annuler ce deploiement de cohorte ?')) {
		$.ajax({
		    type: "POST",
		    url: "supprimer_liaison.php",
		    data : '&id='+id,
		    success:
		    function(retour){
		    	$("#result").html(retour);
		    }
		});	
	}

}