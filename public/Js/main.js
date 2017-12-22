
$(function(){
	
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});



	$('input[data-role="datepicker"]').datepicker({
	  dateFormat: 'yy-mm-dd',
	  yearRange: "-100:+0",
	  changeMonth: true,
	  changeYear: true,
	});

	$('[data-tooltip="tooltip"]').tooltip();

	$('select').each(function(i, e){
	  if ($(this).attr('data-value'))
	  {
	      if ($.trim($(this).data('value')) !== '')
	      {
	          var dato = $(this).data('value');
	          $(this).val(dato);
	      }
	  }
	});

	var fechaPF = "",fechaRF,diferencia;

	window.addEventListener('focus', function() {
	          
	 if(fechaPF == ""){

	            }
	       else{	  
	      			fechaRF= Date.now();
	  				diferencia = fechaRF - fechaPF;	
	  				diferencia = (diferencia / 1000) / 60;	 

	  				if(diferencia > 15){
						  window.close(); 
	                }
	     		}
	});
	 
	window.addEventListener('blur', function() {  
	       fechaPF= Date.now();
	});


    /*error: function (x, status, error) {
        if (x.status == 403) {
            alert("Sorry, your session has expired. Please login again to continue");
            window.location.href ="/Account/Login";
        }
        else {
            alert("An error occurred: " + status + "nError: " + error);
        }
    }*/
});