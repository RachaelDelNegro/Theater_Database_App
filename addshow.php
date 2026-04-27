<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Add Show</title>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php?command=showlist">Theater Database</a>
    <a href="index.php?command=showlist" class="btn btn-outline-light btn-sm">Back to Shows</a>
  </div>
</nav>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">

      <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">

          <div class="text-center mb-4">
            <h1 class="h3">Add New Show</h1>
            <p class="text-muted mb-0">Enter production details to add a show to the database.</p>
          </div>

          <form method="post" action="index.php?command=createshow">

            <div class="mb-3">
              <label class="form-label">Name of Production</label>
              <input type="text" class="form-control" name="title" placeholder="e.g. Wicked" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Screen Writer</label>
              <input type="text" class="form-control" name="screen_writer" placeholder="e.g. Winnie Holzman">
            </div>

            <div class="mb-3">
              <label class="form-label">Setting Description</label>
              <textarea class="form-control" name="setting_description" rows="3" placeholder="e.g. The Land of Oz"></textarea>
            </div>

            <div class="mb-4">
              <label class="form-label">Theme</label>
              <input type="text" class="form-control" name="theme" placeholder="e.g. Musical Fantasy">
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a href="index.php?command=showlist" class="btn btn-outline-secondary">Cancel</a>
              <button type="submit" class="btn btn-secondary">Create Show</button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

</body>
</html>