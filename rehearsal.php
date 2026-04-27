<?php
$eventsByDate = [];

foreach ($events as $event) {
    $eventsByDate[$event["event_date"]][] = $event;
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rehearsal Schedule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <h1 class="display-6">Rehearsal Schedule</h1>
    <p class="text-muted">
      Events for <strong><?= htmlspecialchars($show["title"]) ?></strong>
    </p>
  </div>

  <?php if (empty($eventsByDate)): ?>
    <div class="card shadow-sm">
      <div class="card-body">
        <p class="text-muted mb-0">No rehearsals or events have been scheduled yet.</p>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php foreach ($eventsByDate as $date => $dayEvents): ?>
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <div class="card-header bg-dark text-white">
              <?= htmlspecialchars(date("l, M j", strtotime($date))) ?>
            </div>

            <div class="card-body">
              <?php foreach ($dayEvents as $event): ?>
                <div class="border rounded p-3 mb-3 bg-white">
                  <h3 class="h6 mb-1">
                    <?= htmlspecialchars($event["event_title"]) ?>
                  </h3>

                  <p class="mb-1">
                    <strong>Time:</strong>
                    <?= htmlspecialchars(date("g:i A", strtotime($event["event_time"]))) ?>
                  </p>

                  <p class="mb-0">
                    <strong>Required:</strong>
                    <?= htmlspecialchars($event["required_users"] ?: "No users assigned") ?>
                  </p>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <div class="mt-4">
    <?php if (isset($_SESSION["perms"])): ?>
      <?php if ($_SESSION["perms"] === "actor"): ?>
        <a href="index.php?command=actorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">Back to Actor View</a>
      <?php elseif ($_SESSION["perms"] === "crew"): ?>
        <a href="index.php?command=crewpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">Back to Crew View</a>
      <?php elseif ($_SESSION["perms"] === "director"): ?>
        <a href="index.php?command=directorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">Back to Director View</a>
      <?php endif; ?>
    <?php endif; ?>

    <a href="index.php?command=showlist" class="btn btn-outline-secondary">Back to Show List</a>
  </div>
</main>
</body>
</html>