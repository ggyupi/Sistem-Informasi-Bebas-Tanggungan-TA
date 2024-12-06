<!DOCTYPE html>
<html data-bs-theme="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="<?= JS; ?>jquery-3.7.1.js"></script>
  <link
    rel="stylesheet"
    type="text/css"
    media="screen"
    href="<?= CSS; ?>bootstrap-5.3.3.css" />
  <script src="<?= JS; ?>bootstrap.bundle.min-5.3.3.js"></script>
  <link
    rel="stylesheet"
    type="text/css"
    media="screen"
    href="<?= CSS; ?>login.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <link rel="icon" href="<?= IMGS; ?>KawaiiLogoV1.svg" type="image/x-icon">
  <title>Loginkan dulu</title>
</head>

<body>
  <div id="background-image"></div>
  <div id="form-login" style="background-color: <?= isset($data['not_found']) ? '' : '' ?>;">
    <div id="form-banner">
      <img src="<?= IMGS; ?>jti_polinema.png" />
      <h1>Welcome</h1>
      <p>Login to PBL Bebas TA</p>
    </div>
    <div id="msg-tidak-ditemukan" style="display: <?= isset($data['not_found']) ? 'flex' : 'none' ?>;">
      <svg width="37" height="36" viewBox="0 0 37 36" fill="none" xmlns="http://www.w3.org/2000/svg">
        <mask id="mask0_567_293" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="2" y="1" width="33" height="34">
          <path d="M18.5 33C26.7845 33 33.5 26.2845 33.5 18C33.5 9.7155 26.7845 3 18.5 3C10.2155 3 3.5 9.7155 3.5 18C3.5 26.2845 10.2155 33 18.5 33Z" fill="#555555" stroke="white" stroke-width="3" stroke-linejoin="round" />
          <path d="M22.7426 13.7573L14.2571 22.2428M14.2571 13.7573L22.7426 22.2428" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
        </mask>
        <g mask="url(#mask0_567_293)">
          <path d="M0.5 0H36.5V36H0.5V0Z" fill="var(--bs-body-bg)" />
        </g>
      </svg>
      <p>Data Login Tidak Ditemukan Tuan :(</p>
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
            autocomplete="on"
            name="username" value="<?= isset($data['username']) ? $data['username'] : '' ?>" />
          <label for="input-password" class="form-label form-text-input">Password</label>
          <input
            type="password"
            class="form-control pt-2 pb-2"
            id="input-password"
            placeholder="password"
            name="password" value="<?= isset($data['password']) ? $data['password'] : '' ?>" />
        </div>
        <button
          type="submit"
          class="btn btn-primary container-fluid mb-3 pt-2 pb-2">
          Continue
        </button>
        <div class="mb-1" id="login-as-seperator">
          <p>Login as</p>
        </div>
        <div id="login-as-switch-wrapper">
          <label id="login-as-switch">
            <input type="checkbox" name="isAdmin"
              <?= isset($data['level']) ? ($data['level'] === 'admin' ? 'checked' : '') : '' ?> />
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