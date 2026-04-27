<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Actor Landing Page</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php?command=showlist">Theater Database</a>
    <div class="d-flex gap-2">
      <a href="index.php?command=showlist" class="btn btn-outline-light btn-sm">All Shows</a>
      <a href="login.php" class="btn btn-outline-light btn-sm">Log Out</a>
    </div>
  </div>
</nav>

<main class="container my-5">
  <div class="text-center mb-4">
    <h1 class="display-5">
      Actor View: <?= htmlspecialchars($show["title"]) ?>
    </h1>
    <p class="lead text-muted">Actor-specific databases and show information.</p>
  </div>

  <div class="row g-4">
    <<div class="col-md-6">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h2 class="h5">Character Database</h2>
          <p>View assigned characters, descriptions, and actor assignments.</p>
          <a href="index.php?command=characters&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
            Open Characters
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h2 class="h5">Rehearsal Schedule</h2>
          <p>View upcoming actor rehearsals and full-cast run-throughs.</p>
          <a href="index.php?command=rehearsal&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
            Open Schedule
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h2 class="h5">Cast List</h2>
          <p>View other actors signed up for this production.</p>
          <a href="index.php?command=castlist&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
            Open Cast List
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <a href="index.php?command=showpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
      Back to Show Landing Page
    </a>
    <a href="index.php?command=showlist" class="btn btn-outline-secondary">Back to Show List</a>
  </div>
</main>
</body>
</html>