$(function()
{
	var rows_selected = [];
	var URL = $('#main').data('url');

	//tomado de http://www.gyrocode.com/articles/jquery-datatables-checkboxes/
	function updateDataTableSelectAllCtrl(table)
	{
		var $table             = table.table().node();
		var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
		var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
		var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

		// If none of the checkboxes are checked
		if($chkbox_checked.length === 0)
		{
			chkbox_select_all.checked = false;
			if('indeterminate' in chkbox_select_all)
			{
				chkbox_select_all.indeterminate = false;
			}
		// If all of the checkboxes are chkbox_checked
		} else if ($chkbox_checked.length === $chkbox_all.length) {
			chkbox_select_all.checked = true;
			if('indeterminate' in chkbox_select_all)
			{
				chkbox_select_all.indeterminate = false;
			}
		// If some of the checkboxes are checked
		} else {
			chkbox_select_all.checked = true;
			if('indeterminate' in chkbox_select_all)
			{
				chkbox_select_all.indeterminate = true;
			}
		}
	};

  	$('#TablaPAA tfoot th').each( function () {
        var title = $(this).text();
        if(title!="Menu" && title!="N°"){
          $(this).html( '<input type="text" placeholder="Buscar" />' );
        }
    } );
 
    // DataTable
    var table = $('#TablaPAA').DataTable({
	    responsive: true,
	    columnDefs: [
      		{
	        	targets: 22,
	            searchable: false,
	            orderable: false
          	},{
	            targets: 23,
	            searchable: false,
	            orderable: false,
	            width: '1%',
	            className: 'dt-body-center',
	            render: function (data, type, row) 
				{
					return '<input type="checkbox" class="default" '+(row[3] == 'En planeación' ? 'disabled' : '')+'>';
				}
          	}
        ],
        rowCallback: function(row, data, dataIndex)
        {
        	var rowId = data[1];          
    		if($.inArray(rowId, rows_selected) !== -1)
    		{
    			$(row).find('input[type="checkbox"]').prop('checked', true);
    			$(row).addClass('selected');
  			}
    	},
        dom: 'Bfrtip',
        buttons: ['copy', 'csv', 'excel', 'pdf']
    });
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    });

    $('#TablaPAA tbody').on('click', 'input[type="checkbox"]', function(e)
	{
		var $row = $(this).closest('tr');

		// Get row data
		var data = table.row($row).data();

		// Get row ID
		var rowId = $row.data('row');

		// Determine whether row ID is in the list of selected row IDs 
		var index = $.inArray(rowId, rows_selected);

		// If checkbox is checked and row ID is not in list of selected row IDs
		if(this.checked && index === -1)
		{
			rows_selected.push(rowId);
		// Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
		} else if (!this.checked && index !== -1) {
			rows_selected.splice(index, 1);
		}

		if(this.checked)
		{
			$row.addClass('selected');
		} else {
			$row.removeClass('selected');
		}

		// Update state of "Select all" control
		updateDataTableSelectAllCtrl(table);
		console.log(rows_selected);

		// Prevent click event from propagating to parent
		e.stopPropagation();
	});

	$('#TablaPAA').delegate('button[data-funcion="rechazar"], button[data-funcion="cancelar"]', 'click', function (e)
	{
		var form = $(this).data('funcion');
		var id = $(this).data('rel');
		$('#'+form+'_paa input[name="Id"]').val(id);
		$('#'+form+'_paa textarea[name="Observaciones"]').val('');
		$('#'+form+'_paa textarea[name="Observaciones"]').closest('.form-group').removeClass('has-error');

		$('#modal_'+form).modal('show');
	});

	$('#TablaPAA').delegate('button[data-funcion="Cancelar"]','click',function (e)
	{
		var id = $(this).data('rel');
		$('#rechazar_paa input[name="Id"]').val(id);
		$('#rechazar_paa textarea[name="Observaciones"]').val('');
		$('#rechazar_paa textarea[name="Observaciones"]').closest('.form-group').removeClass('has-error');

		$('#Modal_Eliminar').modal('show');
	});

	$('thead input[name="select_all"]', table.table().container()).on('click', function(e){
		if(this.checked){
			$('#TablaPAA tbody input[type="checkbox"]:not(:checked)').trigger('click');
		} else {
			$('#TablaPAA tbody input[type="checkbox"]:checked').trigger('click');
		}

		// Prevent click event from propagating to parent
		e.stopPropagation();
	});
});