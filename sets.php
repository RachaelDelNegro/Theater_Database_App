<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Sets Database</title>
</head>

<body class="bg-light">
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1>Sets Database</h1>
      <p class="text-muted mb-0">
        Show: <?= htmlspecialchars($show["title"]) ?>
      </p>
    </div>

    <?php if ($_SESSION['perms'] == 'director'): ?>
        <a href="index.php?command=directorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
            Back to Director Page
        </a>
    <?php else: ?>
        <a href="index.php?command=crewpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
        Back to Crew Page
        </a>
    <?php endif; ?>
  </div>

  <form method="get" action="index.php" class="mb-4">
    <input type="hidden" name="command" value="sets">
    <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

    <div class="input-group">
      <input type="text"
             name="search"
             class="form-control"
             placeholder="Search sets..."
             value="<?= htmlspecialchars($_GET["search"] ?? "") ?>">
      <button class="btn btn-dark" type="submit">Search</button>
    </div>
  </form>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h2 class="h5 mb-3">Add New Set Item</h2>

      <form method="post" action="index.php?command=addset" class="row g-3">
        <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

        <div class="col-md-6">
          <label class="form-label">Set Item Name</label>
          <input type="text" name="set_item_name" class="form-control" placeholder="e.g. Emerald City Gate" required>
        </div>

        <div class="col-md-4">
          <label class="form-label">Material</label>
          <input type="text" name="material" class="form-control" placeholder="e.g. Wood, fabric, paint">
        </div>

        <div class="col-md-2 d-grid align-items-end">
          <button type="submit" class="btn btn-primary">Add Set</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="h5 mb-3">Current Sets</h2>

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Set ID</th>
            <th>Show ID</th>
            <th>Set Item Name</th>
            <th>Material</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($sets as $set): ?>
            <tr>
              <td><?= htmlspecialchars($set["set_id"]) ?></td>
              <td><?= htmlspecialchars($set["show_id"]) ?></td>
              <td><?= htmlspecialchars($set["set_item_name"]) ?></td>
              <td><?= htmlspecialchars($set["material"] ?? "") ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($sets)): ?>
        <p class="text-muted">No sets found for this show.</p>
      <?php endif; ?>
    </div>
  </div>

</div>
</body>
</html>