<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Show List</title>
</head>
<body>
<div class="container my-5">

  <div class="text-end">
    <a href="login.php" class="btn btn-secondary">Log out</a>
  </div>

  <div class="text-center">
    <h1 class="page-title text-bg-dark">Select Your Show!</h1>
  </div>

  <div class="text-end my-3">
    <a href="?command=addshow" class="btn btn-sm btn-secondary">
      Add Show
    </a>
  </div>

  <ul class="list-group" id="showList">
    <?php foreach ($shows as $show): ?>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
          <strong><?= htmlspecialchars($show["title"]) ?></strong><br>
          <small class="text-muted">
            Screen Writer: <?= htmlspecialchars($show["screen_writer"] ?? "N/A") ?>
          </small>
        </div>

        <div>
          <a href="index.php?command=showpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-info">
            View Show
          </a>

          <a href="group.php?show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
            Join Show
          </a>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>

</div>
</body>
</html>