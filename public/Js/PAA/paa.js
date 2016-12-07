$(function()
{
   
   $('#TablaPAA').DataTable( {responsive: true,
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf']
    } );

   $('#Modal_AgregarNuevo').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})
   $('#Modal_AprobarCambios').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})
   $('#Modal_Historiaeliminado').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

});
