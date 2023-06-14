<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form id="simple-registration-form" method="post" action="adduser.php">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile_number">Mobile Number</label>
                        <input type="number" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter mobile number" maxlength="11" minlength="11" required>
                    </div>

                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Enter birthday" required>
                    </div>

                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-select" name="gender" id="gender">
                            <option value="" selected>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    
                    <button class="btn btn-success" type="submit" id="submit_button">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $('#birthday').change(function(event) {
                let entered_date = new Date(event.target.value)
                let month_difference = Date.now() - entered_date.getTime()
                let age_difference = new Date(month_difference)
                let year = age_difference.getUTCFullYear()
                let final_age = Math.abs(year - 1970)
                $('#age').val(final_age)
            })

            $('#submit_button').click(function (event) {
                event.preventDefault();

                $('#simple-registration-form').validate({ 
                    rules: {
                        full_name: {
                            required: true
                        },
                        email_address: {
                            required: true,
                            email: true
                        },
                        mobile_number: {
                            required: true,
                            digits: true,
                            minlength: 11 
                        },
                        birthday: {
                            required: true,
                            date: true
                        },
                        age: {
                            required: true,
                            digits: true,
                        },
                        gender: {
                            required: true,
                        },
                    }
                });

                if ($('#simple-registration-form').valid()) {
                    $.ajax({
                        method: "POST",
                        url: 'http://localhost:5000/adduser.php',
                        data: $('#simple-registration-form').serialize(),
                        dataType: 'JSON',
                        success: function(res) {
                            $('#simple-registration-form').trigger('reset')
                            alert('User added to database')
                        },
                        error: function (err) {
                            console.log(err, "ERROR")
                        }
                    })
                }
            })
        })

    </script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script> -->
</body>
</html>