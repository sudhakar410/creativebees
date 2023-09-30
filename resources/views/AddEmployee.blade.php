<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/add.css')}}">
        <title>Add New Employee</title>
    </head>
    <style>
        .error{
            color: red;
            font-size: 12px;
        }
    </style>

    <body>

        <h1>Add New Employee</h1>
        <div class="container">
            <a href="/Home" class="link-button">Back</a>
            <form method="post" action="/new_employee" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <label for="firstname">First Name*:</label>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" >
                    <span id="firstnameError" class="error"></span>


                    <label for="lastname">Last Name*:</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" >
                    <span id="lastnameError" class="error"></span>

                    <label for="date_of_birth">Date of Birth*:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" >
                    <span id="dobError" class="error"></span>


                    <label for="education_qualification">Education Qualification*:</label>
                    <input type="text" name="education_qualification" id="education_qualification" placeholder="Education Qualification" >
                    <span id="eduError" class="error"></span>


                   <label for="address">Address*:</label>
                    <textarea name="address" id="address" placeholder="Address" ></textarea>
                    <span id="addressError" class="error"></span>


                    <label for="email">Email*:</label>
                    <input type="email" name="email" id="email" placeholder="Email" >
                    <span id="emailError" class="error"></span>

                    <label for="phone">PhoneNumber*:</label>
                    <input type="text" name="phone" id="phone" placeholder="Phone" >
                    <span id="phoneError" class="error"></span>


                    <label for="photo">Upload Photo:</label>
                    <input type="file" name="photo" id="photo" accept="image/*"><br><br>

                    <label for="resume">Upload Resume (.pdf):</label>
                    <input type="file" name="resume" id="resume" accept=".pdf">
                    <br><br>

                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <input type="submit" value="Add Employee">
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
