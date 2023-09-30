<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/edit.css')}}">
        <title>Edit Employee Details</title>
    </head>
    <body>
        <h1>Edit Employee</h1>
        <div class="container">
            <a href="/Home" class="btn link-button" >Back</a>

            <form method="post" action="/update_employee" enctype="multipart/form-data">
                @foreach($details as $data)
                <label>Employee id: <input type="text" name="employee_id" value="{{$data->employee_id}}" readonly required>
                <label>First Name: <input type="text" name="firstname" placeholder="First Name"  value="{{$data->firstname}}" required> </label><br>
                <label>Last Name: <input type="text" name="lastname" placeholder="Last Name" value="{{$data->lastname}}" required> </label><br>
                <label>Date of Birth: <input type="date" name="date_of_birth" value="{{$data->date_of_birth}}" required> </label><br>
                <label>Education Qualifiaction:<input type="text" name="education_qualification" placeholder="Education Qualification" value="{{$data->education_qualification}}" required> </label><br>
                <label>Address: <textarea name="address" placeholder="Address" required>{{$data->address}}</textarea> </label><br>
                <label>Email: <input type="email" name="email" placeholder="Email" value="{{$data->email}}" required> </label><br>
                <label>PhoneNumber: <input type="text" name="phone" placeholder="Phone" value="{{$data->phone}}" required> </label><br>
                <label>Upload photo: <input type="file" name="photo" placeholder="Photo" value="{{$data->photo}}" accept="image/*"> </label><br>
                
                @if($data->photo)
                <img src="{{ asset('storage/employee_photos/'.$data->photo ) }}" alt="Employee Photo" width="100"><br>
                @endif
				<label>Resume: <input type="file" name="resume" placeholder="Resume" value="{{$data->resume}}" accept=".pdf"> </label><br>
                @if ($data->resume)
                    <a href="{{ asset('storage/employee_pdfs/' . $data->resume) }}" target="_blank">View PDF</a>
                @endif
                <label><input type="hidden" name="_token" value="<?=csrf_token()?>">
                <input type="submit" value="Update">
                    @endforeach
            </form>
        </div>
    </body>
</html>
