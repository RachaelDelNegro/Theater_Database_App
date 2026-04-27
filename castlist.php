<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Cast List</title>
</head>

<body class="bg-light">
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1>Cast List</h1>
      <p class="text-muted mb-0">
        Show: <?= htmlspecialchars($show["title"]) ?>
      </p>
    </div>

    <a href="index.php?command=actorpage&show_id=<?= $show["show_id"] ?>" class="btn btn-outline-secondary">
      Back to Actor Page
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Actor</th>
            <th>Character</th>
            <th>Main / Side</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($castList as $cast): ?>
            <tr>
              <td><?= htmlspecialchars($cast["username"]) ?></td>
              <td><?= htmlspecialchars($cast["character_name"]) ?></td>
              <td><?= htmlspecialchars($cast["main_side"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($castList)): ?>
        <p class="text-muted">No cast assignments yet.</p>
      <?php endif; ?>

    </div>
  </div>

</div>
</body>
</html>