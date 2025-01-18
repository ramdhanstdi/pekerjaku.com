<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
      body {
          margin: 0;
          font-family: 'Roboto', sans-serif;
          background: linear-gradient(135deg, #6e8efb, #a777e3);
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          color: #333;
      }

      .container {
        width: 100%;
        max-width: 400px;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        margin: 40px auto;
        text-align: center;
      }

      .form-container {
        overflow-y: auto;
        max-height: 80vh;
        scrollbar-width: thin;
        scrollbar-color: #666 #f9f9f9;
      }


      .form {
          display: none;
          animation: fade-in 0.3s ease-in-out;
      }

      .form.active {
          display: block;
      }

      h2 {
          margin-bottom: 10px;
          color: #333;
      }

      p {
          font-size: 14px;
          margin-bottom: 20px;
          color: #666;
      }

      .input-group {
          margin-bottom: 15px;
          text-align: left;
      }

      .input-group label {
          display: block;
          font-size: 14px;
          margin-bottom: 5px;
          color: #444;
      }

      .input-group input {
          width: 100%;
          padding: 10px;
          font-size: 14px;
          border: 1px solid #ddd;
          border-radius: 5px;
          box-sizing: border-box;
          outline: none;
      }

      .input-group input:focus {
          border-color: #6e8efb;
          box-shadow: 0 0 5px rgba(110, 142, 251, 0.5);
      }

      .input-group textarea {
          width: 100%;
          padding: 10px;
          font-size: 14px;
          border: 1px solid #ddd;
          border-radius: 5px;
          box-sizing: border-box;
          outline: none;
      }

      .input-group textarea:focus {
          border-color: #6e8efb;
          box-shadow: 0 0 5px rgba(110, 142, 251, 0.5);
      }

      .actions {
          margin-top: 15px;
      }

      .actions .btn {
          width: 100%;
          background: linear-gradient(135deg, #6e8efb, #a777e3);
          color: #fff;
          padding: 10px;
          font-size: 16px;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          transition: all 0.3s ease;
      }

      .actions .btn:hover {
          background: linear-gradient(135deg, #5b77d6, #9367cf);
      }

      .actions .forgot-password {
          display: block;
          margin-top: 10px;
          font-size: 14px;
          color: #6e8efb;
          text-decoration: none;
      }

      .actions .forgot-password:hover {
          text-decoration: underline;
      }

      .switch-form {
          margin-top: 15px;
          font-size: 14px;
      }

      .switch-form a {
          color: #6e8efb;
          text-decoration: none;
          font-weight: bold;
      }

      .switch-form a:hover {
          text-decoration: underline;
      }

      /* Fade-in animation */
      @keyframes fade-in {
          from {
              opacity: 0;
              transform: translateY(-20px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      .selection {
          display: none;
      }

      .selection.active {
          display: block;
      }

      .selection .btn {
          margin-bottom: 10px;
      }

    .form-double-column {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .input-group {
        flex-basis: 48%;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .alert-box {
    background-color: #EF4A31;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    margin: 20px auto;
    text-align: center;
    position: relative;
    }

    .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
    }

    .alert-message {
    font-size: 16px;
    font-weight: bold;
    color: white;
    }



    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Login Form -->
            <form id="login-form" method="POST" action="#" class="form active">
                @csrf

                <div class="alert-box warning" id="alert-box">
                    <span class="close">&times;</span>
                    <div class="alert-message">Username dan Password Salah!</div>
                </div>

                <h2>Login</h2>
                <p>Welcome back! Please login to your account.</p>
                <div class="input-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="actions">
                    <button type="submit" class="btn">Login</button>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>
                <p class="switch-form">
                    Don't have an account? <a href="#" id="show-selection">Sign Up</a>
                </p>
            </form>

            <!-- Selection Form -->
            <div id="selection-form" class="selection">
                <h2>Choose Account Type</h2>
                <p>Select whether you are an Employer or a Worker to proceed.</p>
                <div class="actions">
                    <button class="btn" id="select-employer" value="2">Employer</button>
                    <button class="btn" id="select-worker" value="3">Worker</button>
                </div>
            </div>

            <!-- Register Form -->
            <form id="register-form" class="form">
                @csrf
                <h2>Register</h2>
                <p>Create your account and join us today!</p>
                <input type="hidden" class="level_user" id="level_user" name="level_user">
                <div class="form-double-column">
                    <div class="input-group">
                      <label for="first-name">First Name</label>
                      <input type="text" name="first_name" id="first-name" placeholder="Enter your first name" required>
                    </div>
                    <div class="input-group">
                      <label for="last-name">Last Name</label>
                      <input type="text" name="last_name" id="last-name" placeholder="Enter your last name" required>
                    </div>
                </div>
                <div class="input-group">
                    <label for="register-email">Email</label>
                    <input type="email" name="email" id="register-email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Password</label>
                    <input type="password" name="password" id="register-password" placeholder="Create a password" required>
                </div>
                <div class="input-group">
                    <label for="register-address">Address</label>
                    <textarea name="address" id="register-address" placeholder="Create a address" cols="30" rows="10"></textarea>
                </div>
                <div class="input-group">
                    <label for="register-password">District</label>
                    <input type="text" name="district" id="register-district" placeholder="Create a district" required>
                </div>
                <div class="input-group">
                    <label for="register-password">City</label>
                    <input type="text" name="regency_city" id="register-city" placeholder="Create a city" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Province</label>
                    <input type="text" name="province" id="register-province" placeholder="Create a province" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Postal Code</label>
                    <input type="text" name="postal_code" id="register-postal" placeholder="Create a poatal code" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Phone Number</label>
                    <input type="text" name="phone_number" id="register-phone" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label for="register-password">WhatsApp Number</label>
                    <input type="text" name="number_whatsapp" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label for="register-password">Photo</label>
                    <input type="file" name="image" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label  name="ktp" for="register-password">KTP</label>
                    <input type="file" name="ktp" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label name="selfiektp" for="register-password">Selfie KTP</label>
                    <input type="file" name="selfiektp" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label  name="skck" for="register-password">SKCK</label>
                    <input type="file" name="skck" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="input-group">
                    <label  name="ijazah" for="register-password">Ijazah</label>
                    <input type="file" name="ijazah" id="register-whatsaapp" placeholder="Create a phone number" required>
                </div>
                <div class="actions">
                    <button type="submit" class="btn">Register</button>
                </div>
                <p class="switch-form">
                    Already have an account? <a href="#" id="show-login">Login</a>
                </p>
            </form>
        </div>
    </div>

    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
          const loginForm = document.getElementById('login-form');
          const registerForm = document.getElementById('register-form');
          const selectionForm = document.getElementById('selection-form');

          const showLogin = document.getElementById('show-login');
          const showSelection = document.getElementById('show-selection');

          const selectEmployer = document.getElementById('select-employer');
          const selectWorker = document.getElementById('select-worker');

          // Show selection form
          showSelection.addEventListener('click', (e) => {
              e.preventDefault();
              loginForm.classList.remove('active');
              selectionForm.classList.add('active');
          });

          // Show register form for employer
          selectEmployer.addEventListener('click', () => {
              selectionForm.classList.remove('active');
              registerForm.classList.add('active');
          });

          // Show register form for worker
          selectWorker.addEventListener('click', () => {
              selectionForm.classList.remove('active');
              registerForm.classList.add('active');
          });

          // Switch to login form
          showLogin.addEventListener('click', (e) => {
              e.preventDefault();
              registerForm.classList.remove('active');
              loginForm.classList.add('active');
          });
      });


        const alertBox = document.getElementById('alert-box');
        const closeBtn = alertBox.querySelector('.close');

        closeBtn.addEventListener('click', () => {
        alertBox.style.display = 'none';
        });

        // Fungsi untuk menampilkan alert
        $('#alert-box').hide();
        function showAlert(message, jenis) {
            alertBox.className = 'alert-box ' + jenis;
            alertBox.querySelector('.alert-message').innerHTML = message;
            alertBox.style.display = 'block';
            setTimeout(() => alertBox.style.display = 'none', 3000);
        }

        // Contoh penggunaan

      $('#select-employer').click(function(){
        console.log($(this).val())
        let value = $(this).val();
        // localStorage.setItem("level_user", value);
        $('#level_user').val(value)
        $('input[name="ktp"]').hide()
        $('label[name="ktp"]').hide()
        $('input[name="selfiektp"]').hide()
        $('label[name="selfiektp"]').hide()
        $('input[name="skck"]').hide()
        $('label[name="skck"]').hide()
        $('input[name="ijazah"]').hide()
        $('label[name="ijazah"]').hide()
      })

      $('#select-worker').click(function(){
        let value = $(this).val();
        $('#level_user').val(value)
        $('input[name="ktp"]').show()
        $('label[name="ktp"]').show()
        $('input[name="selfiektp"]').show()
        $('label[name="selfiektp"]').show()
        $('input[name="skck"]').show()
        $('label[name="skck"]').show()
        $('input[name="ijazah"]').show()
        $('label[name="ijazah"]').show()
        // localStorage.setItem("level_user", value);
      })

      $('#login-form').submit(function(e){
        e.preventDefault();
        console.log('submit');
        const value = $('#login-form').serialize();

        $.ajax({
            url: '/api/login',
            type: 'POST',
            data: value,
            success: function(response) {
                if (response.status) {
                    localStorage.setItem('auth_token', response.access_token);
                    localStorage.setItem('user', response.data);
                    if(response.data.level_user == 1)
                    window.location.href = '/admin/dashboard';
                    if(response.data.level_user == 2)
                    window.location.href = '/majikan/dashboard';
                    if(response.data.level_user == 3)
                    window.location.href = '/pekerja/dashboard';
                    else
                    window.location.href = '/';
                } else {
                    console.log('error',response)
                    showAlert(response?.message, 'warning');
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
      });

      $('#register-form').submit(function(e) {
        e.preventDefault();

        // Create a new FormData object
        const formData = new FormData(this); // Automatically gathers all form fields, including files

        $.ajax({
            url: '/api/registrasi',
            type: 'POST',
            data: formData, // Send FormData instead of serialized data
            contentType: false, // Let jQuery set the correct content type for FormData
            processData: false, // Prevent jQuery from processing the FormData
            success: function(response) {
                    if (response.status) {
                        window.location.href = '/login';
                    } else {
                        console.log('error', response);
                        showAlert(response?.message, 'warning');
                    }
                },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
            });
        });

    </script>
</body>
</html>
