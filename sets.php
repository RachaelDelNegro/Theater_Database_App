<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Sets</title>
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
    <h1 class="display-5">Sets</h1>
    <p class="lead text-muted">
      Sets for <?= htmlspecialchars($show["title"]) ?>
    </p>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      <?php if (empty($sets)): ?>
        <p class="text-muted mb-0">No sets have been added for this show yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>Set Piece</th>
                <th>Material</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($sets as $set): ?>
                <tr>
                  <td><?= htmlspecialchars($set["set_item_name"]) ?></td>
                  <td><?= htmlspecialchars($set["material"]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

    </div>
  </div>

  <div class="mt-4">
    <a href="index.php?command=crewpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
      Back to Crew View
    </a>

    <a href="index.php?command=showlist" class="btn btn-outline-secondary">
      Back to Show List
    </a>
  </div>

</main>

</body>
</html>