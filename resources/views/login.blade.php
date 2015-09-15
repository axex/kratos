<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="/assets/vendors/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/login.css">
</head>

{{--
  TODO:
     * Login with {GitHub, Weibo}
     * Forget password link
--}}

<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">

      <form class="login-form" method="post">

        {!! csrf_field() !!}

        <div class="form-group">
          <label for="email">Email address</label>
          <input type="text" id="email" name="email" class="form-control"
                 placeholder="Please enter your Login Email">
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>

        <p class="helper-block">Forget password?</p>

        <button type="submit" class="btn btn-success btn-block btn-lg">Login</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
