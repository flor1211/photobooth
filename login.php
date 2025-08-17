<?php
    session_start();

    $successMessage = $_SESSION['login_success'] ?? null;
    $errorMessage   = $_SESSION['login_error'] ?? null;

    if (isset($_SESSION["user"])) {
        header("Location: index.php");
        exit();
    }
    
    $users = [
        "jpcs" => '$2y$10$38kjVi2HGprvQX2T3aChNOmgVU6dsUEh14MAU3q9ff5K0Q0mvuxOq',
    ];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";

        if (isset($users[$username]) && password_verify($password, $users[$username])) {
            $_SESSION["user"] = $username;
            $_SESSION['login_success'] = "Welcome!";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid login credentials.";
            header("Location: login.php");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Log In | Chat.io</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <!-- Bootstrap Icon CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <style>
      html,
      body {
        height: 100%;
        margin: 0;
      }
      .auth-wrapper {
        height: 100vh;
      }
      .auth-box {
        max-width: 800px;
        width: 80%;
      }

      .left-panel {
        background-image: url("assets/background.png");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      .btn-bd-primary {
        font-weight: 600;
        color: #fff;
        border-color:  rgb(51, 217, 193);
        background-color:  rgb(0, 190, 165);
      }

      .btn-bd-primary:hover,
      .btn-bd-primary:focus {
        border-color: rgb(0, 190, 165);
        background-color:  rgb(0, 152, 132);
        color: #fff;
      }

      .btn-bd-primary:active {
        border-color:  rgb(51, 217, 193);
        background-color:  rgb(0, 190, 165);
      }

    </style>
  </head>
  <body>
    <div class="container-fluid d-flex justify-content-center align-items-center auth-wrapper">
      <div class="row auth-box border shadow-lg h-auto flex-column flex-md-row">

        <!-- Left Side -->
        <div class="col-md-6 p-5 left-panel d-flex justify-content-center align-items-center position-relative text-center text-white p-4 flex-column">
          <!-- Dark overlay -->
          <div class="position-absolute top-0 start-0 w-100 h-100" style="background-color: rgba(0, 0, 0, 0.5); z-index: 1">
          </div>

          <div class=" position-relative z-2 m-3">
            <img
              class="rounded-circle mb-3"
              src="/assets/jpcslogo.png"
              alt="Logo"
              style="width: 100px; height: auto; z-index: 2; margin-bottom: 20px;"/>
            <h2 class="fw-medium mb-2">PHOTOBOOTH</h2>
            <p class="mb-0">
              JPCS
            </p>
          </div>
        </div>

        <!-- Right Side -->
        <div class="col-md-6 d-flex justify-content-center align-items-center py-4 py-md-0">
          <form  method="POST" class="w-100 px-4" style="max-width: 320px">
            <div class="form-floating mt-3 mb-3">
              <input name="username" class="form-control" id="username" placeholder="Username" required/>
              <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3 position-relative">
              <input name="password" type="password" class="form-control" id="password" placeholder="Password" required/>
              <label for="password">Password</label>
              <button type="button" id="togglePassword" class="btn btn-sm position-absolute top-50 end-0 translate-middle-y me-2" tabindex="-1">
                <i id="eyeIcon" class="bi bi-eye"></i>
              </button>
            </div>

            <div class="mt-3 text-center">
              <button class="btn btn-bd-primary w-100">Log In</button>
            </div>
          </form>
 
        </div>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      let toggle = document.getElementById("togglePassword");
      let eyeicon = document.getElementById("eyeIcon");
      let password = document.getElementById("password");

      toggle.onclick = function () {
        if (password.type == "password") {
          password.type = "text";
          eyeicon.classList.remove("bi-eye");
          eyeicon.classList.add("bi-eye-slash");
        } else if (password.type == "text") {
          password.type = "password";
          eyeicon.classList.remove("bi-eye-slash");
          eyeicon.classList.add("bi-eye");
        }
      };
    </script>


    <!-- SweetAlert -->
    <?php if ($successMessage): ?>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          allowOutsideClick: false,
          text: <?= json_encode($successMessage) ?>,
          showConfirmButton: false,
          timer: 1500,
          timerProgressBar: true,
          didClose: () => {
            window.location.href = 'index.php';
          }
        });
      });


    </script>
    <?php endif; ?>

    <!-- SweetAlert for Error -->
    <?php if ($errorMessage): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
      Swal.fire({
        icon: 'error',
        title: 'Invalid',
        allowOutsideClick: false,
        text: <?= json_encode($errorMessage) ?>,
        // confirmButtonText: 'Try Again'
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didClose: () => {
          window.location.href = 'login.php';
        }
      });
    });

    </script>
    <?php endif; ?>

  </body>
</html>

<?php
    unset($_SESSION['login_success'], $_SESSION['login_error']);

?>
