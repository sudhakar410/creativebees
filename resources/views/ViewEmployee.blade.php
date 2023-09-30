<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/edit.css')}}">
        <title>View Employee Details</title>
    </head>
    <body>
        <h1>View Employee</h1>
            <a href="/Home" class="btn link-button">Back</a>
        <div class="container">
                @foreach($details as $data)
                <label>Employee id: <input type="text" name="employee_id" value="{{$data->employee_id}}" readonly></label><br>
                <label>First Name: <input type="text" name="firstname" placeholder="First Name"  value="{{$data->firstname}}" readonly> </label><br>
                <label>Last Name: <input type="text" name="lastname" placeholder="Last Name" value="{{$data->lastname}}" readonly> </label><br>
                <label>Date of Birth: <input type="date" name="date_of_birth" value="{{$data->date_of_birth}}" readonly> </label><br>
                <label>Education Qualifiaction:<input type="text" name="education_qualification" placeholder="Education Qualification" value={{$data->education_qualification}} readonly> </label><br>
                <label>Address: <textarea name="address" placeholder="Address" readonly>{{$data->address}}</textarea> </label><br>
                <label>Email: <input type="email" name="email" placeholder="Email" value="{{$data->email}}" readonly> </label><br>
                <label>PhoneNumber: <input type="text" name="phone" placeholder="Phone" value="{{$data->phone}}" readonly> </label><br>
                <label>Photo: <input type="text" name="photo" placeholder="Photo " value="{{$data->photo}}" readonly> </label><br>
                @if($data->photo)
                <img src="{{ asset('storage/employee_photos/'.$data->photo ) }}" alt="Employee Photo" width="100"><br>
                @endif
                <label>Resume: <input type="text" name="resume" placeholder="Resume" value="{{$data->resume}}" readonly> </label><br>
                 @if ($data->resume)
                    <a href="{{ asset('storage/employee_pdfs/' . $data->resume) }}" target="_blank">View PDF</a>
                @endif
                <label><input type="hidden" name="_token" value="<?=csrf_token()?>">
                    @endforeach
        </div>
    </body>
</html>
