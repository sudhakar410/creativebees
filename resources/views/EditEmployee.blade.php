<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/edit.css')}}">
        <title>Edit Employee Details</title>
    </head>
    <style>
        .error{
            color: red;
        }
    </style>
    <body>
        <h1>Edit Employee</h1>
        <div class="container">
            <a href="/Home" class="btn link-button" >Back</a>

            <form method="post" action="/update_employee" enctype="multipart/form-data" onsubmit="return validateForm()">
                @foreach($details as $data)
                <label>Employee id: <input type="text" name="employee_id" value="{{$data->employee_id}}" readonly required>
                <label>First Name: <input type="text" name="firstname" placeholder="First Name"  value="{{$data->firstname}}" required> </label><br>
                <span id="firstnameError" class="error"></span>

                <label>Last Name: <input type="text" name="lastname" placeholder="Last Name" value="{{$data->lastname}}" required> </label><br>
                <span id="lastnameError" class="error"></span>

                <label>Date of Birth: <input type="date" name="date_of_birth" value="{{$data->date_of_birth}}" required> </label><br>
                <span id="dobError" class="error"></span>

                <label>Education Qualifiaction:<input type="text" name="education_qualification" placeholder="Education Qualification" value="{{$data->education_qualification}}" required> </label><br>
                <span id="eduError" class="error"></span>


                <label>Address: <textarea name="address" placeholder="Address" required>{{$data->address}}</textarea> </label><br>
                <span id="addressError" class="error"></span>


                <label>Email: <input type="email" name="email" placeholder="Email" value="{{$data->email}}" required> </label><br>
                <span id="emailError" class="error"></span>


                <label>PhoneNumber: <input type="text" name="phone" placeholder="Phone" value="{{$data->phone}}" required> </label><br>
                <span id="phoneError" class="error"></span>


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

<script>
    function validateForm() {

        // Reset error messages
        document.getElementById('firstnameError').textContent = '';
        document.getElementById('lastnameError').textContent = '';
        document.getElementById('dobError').textContent = '';
        document.getElementById('eduError').textContent = '';
        document.getElementById('addressError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('phoneError').textContent = '';

        // Get form values
        var firstname = document.getElementById('firstname').value;
        var lastname = document.getElementById('lastname').value;
        var dob = document.getElementById('date_of_birth').value;
        var eduQualification = document.getElementById('education_qualification').value;
        var address = document.getElementById('address').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;

        // Perform validation
        var isValid = true;


        if (firstname.trim() === '') {
            document.getElementById('firstnameError').textContent = 'First Name is required';
            isValid = false;
        }

        if (lastname.trim() === '') {
            document.getElementById('lastnameError').textContent = 'Last Name is required';
            isValid = false;
        }

        if (dob.trim() === '') {
            document.getElementById('dobError').textContent = 'Date of Birth is required';
            isValid = false;
        } else if (!isValidDate(dob)) {
            document.getElementById('dobError').textContent = 'Invalid Date of Birth';
            isValid = false;
        }

        if (eduQualification.trim() === '') {
            document.getElementById('eduError').textContent = 'Education Qualification is required';
            isValid = false;
        }

        if (address.trim() === '') {
            document.getElementById('addressError').textContent = 'Address is required';
            isValid = false;
        }

        if (email.trim() === '') {
            document.getElementById('emailError').textContent = 'Email is required';
            isValid = false;
        } else if (!isValidEmail(email)) {
            document.getElementById('emailError').textContent = 'Invalid Email';
            isValid = false;
        }

        if (phone.trim() === '') {
            document.getElementById('phoneError').textContent = 'Phone Number is required';
            isValid = false;
        } else if (!isValidPhone(phone)) {
            document.getElementById('phoneError').textContent = 'Invalid Phone Number';
            isValid = false;
        }

        // Add more validations for photo and resume if needed

        return isValid;
    }

    function isValidDate(dateString) {
        var regex = /^\d{4}-\d{2}-\d{2}$/;
        return regex.test(dateString);
    }

    function isValidEmail(email) {
        var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function isValidPhone(phone) {
        var regex = /^\d{10}$/;
        return regex.test(phone);
    }
</script>