<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="{{asset('client/assets/img/logoCombo.png')}}"><img src="{{asset('client/assets/img/logoCombo.png')}}" width="100" alt="Hairtricandlashility"></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      @error('email')
      <div class="alert alert-danger" role="alert">
          {{ $message }}
      </div>
      @enderror
      <form action="/login-fill" method="post">
        @csrf
        <div class="input-group mb-3">
            <input name="email" type="email" id="email" class="form-control" placeholder="Email"/>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input name="password" type="password" id="password" class="form-control" placeholder="Password"/>
          <div class="input-group-append">
                <button id="checkPass" class="btn btn-outline-secondary" type="button"><i class="fas fa-eye showPass"></i><i style="display: none" class="fas fa-eye-slash hidePass"></i></button>  
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      {{-- <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> --}}
      <!-- /.social-auth-links -->

      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> --}}
      <p class="mb-0">
        <a href="/" class="text-center">Go to booking page</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<script>
    const password = document.getElementById("password");
    const checkPass = document.getElementById("checkPass");
    const showPass = document.querySelector(".showPass");
    const hidePass = document.querySelector(".hidePass")

    checkPass.addEventListener("click", function() {
      if (password.type == "password") {
        password.type = "text";
        showPass.style.display = "none";
        hidePass.style.display = "block";
      } else {
        password.type = "password";
        showPass.style.display = "block";
        hidePass.style.display = "none";
      }
    })
  </script>
</body>
</html>
