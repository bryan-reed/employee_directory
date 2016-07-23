<?php
//Include init file
require_once 'includes/init.php';
//Get data to be passed to javascript
$data = generate_data();

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Organization Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  </head>
  <body>
  	<div class="container-fluid">
  		<h1 class="text-center">Organization Table</h1>
	  	<table id="org_table" class="table table-striped table-bordered">
			<thead>
	  			<tr>
	  				<th>Employee Name</th>
	  				<th>Boss Name</th>
	  				<th>Distance from CEO</th>
	  				<th>Total Subordinates</th>
	  			</tr>
	  		</thead>
	  		<tfoot>
	  			<tr>
	  				<th>Employee Name</th>
	  				<th>Boss Name</th>
	  				<th>Distance from CEO</th>
	  				<th>Total Subordinates</th>
	  			</tr>
	  		</tfoot>
	  	</table>
	  </div>
  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="http://code.jquery.com/jquery-1.12.3.min.js"></script>
    <!-- Use datatables to handle table -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script>
    //Initialize datatable on document ready
    $(document).ready(function() {
	    $('#org_table').DataTable( {
		    data: <?php print $data;?>,
		    processing: true,
		    language: {
		        searchPlaceholder: "Employee Name" //Placeholder for search box
		    },
		    order: [], //No default sort applied
		    columns: [
		        { data: 'name' },
		        { data: 'bossName' },
		        { data: 'depth' },
		        { data: 'numSubordinates' }
		    ]
		} );
	} );
    </script>
  </body>
</html>