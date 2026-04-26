<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="signup.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <title>Document</title>
</head>

<?php 
  include("TheaterController.php");
?>

<script>
  function checkValues() {
    let user = document.getElementById("username");

    let password = document.getElementById("password");

    if ((user.value.length !== 0) && (password.value.length !== 0)) {
      document.getElementById("signupform").action = "?command=create_user";

      document.getElementById("username").value = user.value;
      document.getElementById("password").value = password.value;

      document.getElementById("signupform").submit();
    }
  }
</script>

<body>
<section id="signup">
  <div class="container-lg">
    <div class = "text-center">
      <h2>Sign up for an account</h2>
      <small class="text-secondary">Already have an account?
        <a href="login.php">Log in</a>
      </small>
    </div>

    <div class="row justify-content-center my-5">
      <div class="col-lg-6">
        <form onsubmit="checkValues(); return false;" method="POST" id="signupform">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="e.g. spongebob">
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="e.g. pineapple123">
          </div>
          <div id="passwordHelpBlock" class="form-text">
            Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
          </div>
          <button class="btn btn-secondary" type="submit">
            Signup
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
</body>
</html>

  