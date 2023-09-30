<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/table.css')}}">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <link rel="Stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
        <link href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" >
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
        <title>All Employees Details</title>
    </head>
    <style type="text/css">
      .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}

.alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

/* Hide the alert initially */
.alert-hidden {
    display: none;
}</style>
    <script>
        window.onload = function(){
          new JsDatePick({
            useMode:2,
            target:"FromDate",
            dateFormat:"%Y-%m-%d"

          });

          new JsDatePick({
            useMode:2,
            target:"ToDate",
            dateFormat:"%Y-%m-%d"});
        };

        function myFunction(name) {
          var table = $('#employeeTable').DataTable();
            table.search( name ).draw();
              $("#MyTable1_wrapper [type='search']").focus();
              $("html, body").animate({
                scrollTop: $("#MyTable1_wrapper").offset().top
                },2000);
        }
      </script>
      <script>
      $(document).ready(function()
      {
        var table = $('#employeeTable').DataTable({
          "pageLength": 20,
           "order": [[ 0, "asc" ]],
          dom: 'Bfrtip',
          buttons: [{
                   extend:'excel',
                   title: '',
				           text: 'Export',
                   filename: 'Employee Details',
                   exportOptions: {
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            }
                  // exportOptions: {
                    //columns: 'th:not(:last-child)'
         //}
          },
        ],
          "oLanguage": {
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
          }
        });
          $("#employeeTable thead tr th").each( function ( i ) {

          if ($(this).text() !== '') {
                var isStatusColumn = (($(this).text() == 'Status') ? true : false);
            var select = $('<select id="data-filter" ><option value="">All</option></select>')
                    .appendTo( $(this).empty() )
                    .on( 'change', function () {
                        var val = $(this).val();

                        table.column( i )
                            .search( val ? '^'+$(this).val()+'$' : val, true, false )
                            .draw();
                    } );

            // Get the Status valuees a specific way since the status is a anchor/image
            if (isStatusColumn) {
              var statusItems = [];

                      /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### */
              table.column( i ).nodes().to$().each( function(d, j){
                var thisStatus = $(j).attr("data-filter");
                if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
              } );

              statusItems.sort();

              $.each( statusItems, function(i, item){
                  select.append( '<option value="'+item+'">'+item+'</option>' );
              });
            }
            else {
              table.column( i ).data().unique().sort().each( function ( d, j ) {

              if (d !== "") {
                  select.append('<option value="' + d + '">' + d + '</option>')
        }
                  } );
            }

          }
          } );

      });
      </script>
    <body>

        <h1>OverAll Employees Details</h1>
        <a href="/AddEmployee" class="link-button">Add Employee</a>
		<!-- resources/views/import.blade.php -->

<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="file"></label>
    <input type="file" name="file" accept=".csv" required="">
    <button type="submit">Import CSV</button>
  

    <a href="{{ route('download-csv-template') }}" class="btn ">Download Template</a>


</form>
	@if(session('success'))
    <div id="success-alert" class="alert alert-success" style="text-align: center;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div id="error-alert" class="alert alert-danger" style="text-align: center;">
        {{ session('error') }}
    </div>
@endif

        <table id="employeeTable" class="display" cellspacing="0" width="100%" >
            <thead>
                <tr id="data-filter" >
					<th width="5%">Sno</th>
                    <th width="10%">Employee ID</th>
                    <th width="10%">First Name</th>
                    <th width="10%" >Last Name</th>
                    <th width="10%" >Date of Birth</th>
                    <th width="10%">Education</th>
                    <th width="10%">Address</th>
                    <th width="10%">Email</th>
                    <th width="10%">Phone</th>
                    <th width="10%">Photo</th>
                    <th width="10%">Resume</th>
                     <th width="10%"></th>
                </tr>
                <tr style="background-color:#79AAF3;color:#0c0c0c;">
				    <td width="5%">Sno</td>
                    <td width="5%" class="col1" style="background-color:#79AAF3!important;color: #000000;">Employee ID</td>
                    <td width="10%" class="col2" style="background-color:#79AAF3; color: #000000;">First Name</td>
                    <td width="10%">Last Name</td>
                    <td width="10%">Date of Birth</td>
                    <td width="10%">Education</td>
                    <td width="10%">Address</td>
                    <td width="10%">Email</td>
                    <td width="10%">Phone</td>
                    <td width="10%">Photo</td>
                    <td width="10%">Resume</td>
                   <td width="10%">Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $value)
                    <tr>
					
						<td>{{$loop->iteration}}</td>
                        <td>{{$value->employee_id}}</td>
                        <td>{{$value->firstname}}</td>
                        <td>{{$value->lastname}}</td>
                        <td>{{$value->date_of_birth}}</td>
                        <td>{{$value->education_qualification}}</td>
                        <td>{{$value->address}}</td>
                        <td>{{$value->email}}</td>
                        <td>{{$value->phone}}</td>
                        <td>{{$value->photo}}</td>
                        <td>{{$value->resume}}</td>
                        <td>
								<a  href="/view_emp/{{$value->employee_id}}">View</a> |
                                <a  href="/edit_emp/{{$value->employee_id}}">Edit</a> |
                                <a href="javascript:void(0);" onclick="confirmDelete('{{ $value->employee_id }}')">Delete</a>
                            </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            function confirmDelete(employeeId)
            {
                var confirmDelete = confirm("Are you sure you want to delete this employee record?");
                if (confirmDelete)
                {
                    window.location.href = "/del_emp/" + employeeId;
                }
            }
        </script>
        <script>
    // Automatically hide success and error alerts after 5 seconds
    setTimeout(function(){
        $('#success-alert, #error-alert').fadeOut('slow');
    }, 5000);
</script>
    </body>
</html>
