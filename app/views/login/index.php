<!DOCTYPE html>
<html data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="<?= JS; ?>jquery-3.7.1.js" type="text/jsx"></script>
    <link
      rel="stylesheet"
      type="text/css"
      media="screen"
      href="<?= CSS; ?>bootstrap-5.3.3.css"
    />
    <script src="<?= JS; ?>bootstrap-5.3.3.js" type="text/jsx"></script>
    <link
      rel="stylesheet"
      type="text/css"
      media="screen"
      href="<?= CSS; ?>login.css"
    />
    <title>Loginkan dulu</title>
  </head>
  <body>
    <div id="background-image"></div>
    <div id="form-login">
      <div id="form-banner">
        <img src="<?= IMGS; ?>jti_polinema.png" />
        <h1>Welcome</h1>
        <p>Login to PBL Bebas TA</p>
      </div>
      <div id="form-input">
        <form method="post" action="postLogin">
          <div class="mb-3">
            <label for="input-username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control pt-2 pb-2 mb-1"
              id="input-username"
              placeholder="username"
              name="username"
            />
            <label for="input-password" class="form-label form-text-input"
              >Password</label
            >
            <input
              type="password"
              class="form-control pt-2 pb-2"
              id="input-password"
              placeholder="password"
              name="password"
            />
          </div>
          <button
            type="submit"
            class="btn btn-primary container-fluid mb-3 pt-2 pb-2"
          >
            Continue
          </button>
          <div class="mb-1" id="login-as-seperator">
            <p>Login as</p>
          </div>
          <div id="login-as-switch-wrapper">
            <label id="login-as-switch">
              <input type="checkbox" name="isAdmin" />
              <span id="login-as-switch-slider"></span>
              <div id="login-as-switch-options">
                <p>User</p>
                <p>Admin</p>
              </div>
            </label>
          </div>
        </form>
      </div>
    </div>

    <!-- <script>
      $(document).ready(function() {
        $('#form-login').on('submit', function(e) {
          e.preventDefault(); // Prevent the default form submission

          var formData = $(this).serialize(); // Serialize form data

          $.ajax({
            type: 'POST',
            url: '/login/login', // Use the form's action attribute as the URL
            data: formData,
            success: function(response) {
              console.log('Form submitted successfully:', response);
              // Handle the response here (e.g., redirect, display message, etc.)
            },
            error: function(xhr, status, error) {
              console.error('Form submission failed:', error);
              // Handle the error here
            }
          });
        });
      });
    </script> -->

    <script>
      function clamp(number, min, max) {
        return Math.max(min, Math.min(number, max));
      }

      function backgroundMove(event) {
        const position = document.getElementById("background-image");
        const x = clamp((window.innerWidth / 2 - event.pageX) / 90, -4, 4);
        const y = clamp((window.innerHeight / 2 - event.pageY) / 90, -4, 4);

        position.style.transform = `translateX(-${50 + x}%) translateY(-${
          50 + y
        }%)`;
      }
      document.addEventListener("mousemove", backgroundMove);
    </script>
  </body>
</html>
