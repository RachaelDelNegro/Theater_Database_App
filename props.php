<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Props Database</title>
</head>

<body class="bg-light">
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1>Props Database</h1>
      <p class="text-muted mb-0">
        Show: <?= htmlspecialchars($show["title"]) ?>
      </p>
    </div>

    <a href="index.php?command=crewpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
      Back to Crew Page
    </a>
  </div>

  <!-- SEARCH BAR -->
  <form method="get" action="index.php" class="mb-4">
    <input type="hidden" name="command" value="props">
    <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

    <div class="input-group">
      <input type="text" 
             name="search" 
             class="form-control" 
             placeholder="Search props..."
             value="<?= htmlspecialchars($_GET["search"] ?? "") ?>">
      <button class="btn btn-dark" type="submit">Search</button>
    </div>
  </form>

  <!-- ADD PROP -->
  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h2 class="h5 mb-3">Add New Prop</h2>

      <form method="post" action="index.php?command=addprop" class="row g-3">
        <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">

        <div class="col-md-10">
          <input type="text" name="item_name" class="form-control" placeholder="e.g. Elphaba's Broom" required>
        </div>

        <div class="col-md-2 d-grid">
          <button type="submit" class="btn btn-primary">Add Prop</button>
        </div>
      </form>
    </div>
  </div>

  <!-- TABLE -->
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="h5 mb-3">Current Props</h2>

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Prop ID</th>
            <th>Show ID</th>
            <th>Item Name</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($props as $prop): ?>
            <tr>
              <td><?= htmlspecialchars($prop["prop_id"]) ?></td>
              <td><?= htmlspecialchars($prop["show_id"]) ?></td>
              <td><?= htmlspecialchars($prop["item_name"]) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($props)): ?>
        <p class="text-muted">No props found.</p>
      <?php endif; ?>
    </div>
  </div>

</div>
</body>
</html>