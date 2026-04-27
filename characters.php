<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Characters</title>
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
    <h1 class="display-5">Characters</h1>
    <p class="lead text-muted">
      Characters for <?= htmlspecialchars($show["title"]) ?>
    </p>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <?php if (empty($characters)): ?>
        <p class="text-muted mb-0">No characters have been added for this show yet.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark">
              <tr>
                <th>Character</th>
                <th>Role Type</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($characters as $character): ?>
                <tr>
                  <td><?= htmlspecialchars($character["character_name"]) ?></td>
                  <td>
                    <?php if ($character["main_side"] === "main"): ?>
                      <span class="badge bg-primary">Main</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Side</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="mt-4">
    <a href="index.php?command=actorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
      Back to Actor View
    </a>

    <a href="index.php?command=showlist" class="btn btn-outline-secondary">
      Back to Show List
    </a>
  </div>
</main>

</body>
</html>