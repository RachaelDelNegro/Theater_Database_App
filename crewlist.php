<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Crew List</title>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php?command=showlist">Theater Database</a>
    <a href="index.php?command=showpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-light btn-sm">
      Back to Show
    </a>
  </div>
</nav>

<main class="container my-5">
  <div class="text-center mb-4">
    <h1 class="display-5">Crew List</h1>
    <p class="lead text-muted">
      Crew members signed up for <?= htmlspecialchars($show["title"]) ?>
    </p>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (empty($crew)): ?>
        <p class="text-muted mb-0">No crew members have joined this show yet.</p>
      <?php else: ?>
        <ul class="list-group list-group-flush">
          <?php foreach ($crew as $member): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><?= htmlspecialchars($member["username"]) ?></span>
              <span class="badge bg-secondary">
                <?= htmlspecialchars($member["perms"]) ?>
              </span>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
  </div>

  <div class="mt-4">
    <a href="index.php?command=directorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
      Back to Director View
    </a>

    <a href="index.php?command=showlist" class="btn btn-outline-secondary">
      Back to Show List
    </a>
  </div>
</main>

</body>
</html>