<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Costumes Database</title>
</head>

<body class="bg-light">
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1>Costumes Database</h1>
      <p class="text-muted mb-0">
        Show: <?= htmlspecialchars($show["title"]) ?> 
        | Show ID: <?= htmlspecialchars($show["show_id"]) ?>
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
    <input type="hidden" name="command" value="costumes">
    <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

    <div class="input-group">
      <input type="text"
             name="search"
             class="form-control"
             placeholder="Search costumes..."
             value="<?= htmlspecialchars($_GET["search"] ?? "") ?>">
      <button class="btn btn-dark" type="submit">Search</button>
    </div>
  </form>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h2 class="h5 mb-3">Add New Costume</h2>

      <form method="post" action="index.php?command=addcostume" class="row g-3">
        <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

        <div class="col-md-3">
          <label class="form-label">Costume Name</label>
          <input type="text" name="costume_name" class="form-control" placeholder="e.g. Emerald Dress" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">Clothing Color</label>
          <input type="text" name="clothing_color" class="form-control" placeholder="e.g. Green">
        </div>

        <div class="col-md-3">
          <label class="form-label">Character ID</label>
          <input type="number" name="character_id" class="form-control" placeholder="e.g. 1">
        </div>

        <div class="col-md-2">
          <label class="form-label">Size</label>
          <input type="text" name="size" class="form-control" placeholder="e.g. M">
        </div>

        <div class="col-md-1 d-grid align-items-end">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="h5 mb-3">Current Costumes</h2>

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Costume ID</th>
            <th>Show ID</th>
            <th>Costume Name</th>
            <th>Clothing Color</th>
            <th>Character ID</th>
            <th>Size</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($costumes as $costume): ?>
            <tr>
              <td><?= htmlspecialchars($costume["costume_id"]) ?></td>
              <td><?= htmlspecialchars($costume["show_id"]) ?></td>
              <td><?= htmlspecialchars($costume["costume_name"]) ?></td>
              <td><?= htmlspecialchars($costume["clothing_color"] ?? "") ?></td>
              <td><?= htmlspecialchars($costume["character_id"] ?? "") ?></td>
              <td><?= htmlspecialchars($costume["size"] ?? "") ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($costumes)): ?>
        <p class="text-muted">No costumes found for this show.</p>
      <?php endif; ?>
    </div>
  </div>

</div>
</body>
</html>