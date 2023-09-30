<html>
    <head>
        <link rel="stylesheet" href="{{asset('css/add.css')}}">
        <title>Add New Employee</title>
    </head>
    <body>

        <h1>Add New Employee</h1>
        <a href="/Home" class="link-button">Home</a>
        <div class="form-container">
            <form method="post" action="/new_employee" enctype="multipart/form-data">
                    <label for="firstname">First Name*:</label>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required>
                    <label for="lastname">Last Name*:</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
                    <label for="date_of_birth">Date of Birth*:</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" required>
                    <label for="education_qualification">Education Qualification*:</label>
                    <input type="text" name="education_qualification" id="education_qualification" placeholder="Education Qualification" required>
                    <label for="address">Address*:</label>
                    <textarea name="address" id="address" placeholder="Address" required></textarea>
                    <label for="email">Email*:</label>
                    <input type="email" name="email" id="email" placeholder="Email" required>
                    <label for="phone">PhoneNumber*:</label>
                    <input type="text" name="phone" id="phone" placeholder="Phone" required>
                    <label for="photo">Upload Photo:</label>
                    <input type="file" name="photo" id="photo" placeholder=" accept="image/*">
                    <label for="resume">Upload Resume (.pdf):</label>
                    <input type="file" name="resume" id="resume" placeholder="Resume URL" accept=".pdf">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <input type="submit" value="Add Employee">
            </form>
        </div>
    </body>
</html>
