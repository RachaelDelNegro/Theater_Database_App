<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title><?= htmlspecialchars($show["title"]) ?></title>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php?command=showlist">Theater Database</a>
    <a href="index.php?command=showlist" class="btn btn-outline-light btn-sm">All Shows</a>
  </div>
</nav>

<main class="container my-5">

  <div class="text-center mb-4">
    <h1 class="display-5"><?= htmlspecialchars($show["title"]) ?></h1>
    <p class="lead text-muted">
      <?= htmlspecialchars($show["setting_description"] ?? "") ?>
    </p>
  </div>

  <div class="row g-4">

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Director(s)</h3>

          <?php if (empty($directors)): ?>
            <p class="text-muted">No director has joined yet.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($directors as $director): ?>
                <li class="list-group-item">
                  <?= htmlspecialchars($director["username"]) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Signed-Up Users</h3>

          <?php if (empty($members)): ?>
            <p class="text-muted">No users have joined this show yet.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($members as $member): ?>
                <li class="list-group-item">
                  <?= htmlspecialchars($member["username"]) ?>
                  —
                  <?= htmlspecialchars($member["perms"] ?? "No Role") ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Rehearsal Schedule</h3>

          <?php if (empty($events)): ?>
            <p class="text-muted">No rehearsals scheduled yet.</p>
          <?php else: ?>
            <ul class="list-group list-group-flush">
              <?php foreach ($events as $event): ?>
                <li class="list-group-item">
                  <strong><?= htmlspecialchars($event["event_title"]) ?></strong><br>
                  <?= htmlspecialchars($event["event_date"]) ?>
                  <?= htmlspecialchars($event["event_time"]) ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </div>

  <div class="mt-4">
    <?php if ($_SESSION['perms'] == 'actor'): ?>        
      <a href="index.php?command=actorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
        Go to the Actor Page
      </a>
    <?php elseif ($_SESSION['perms'] == 'crew'): ?>
      <a href="index.php?command=crewpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
        Go to the Crew Page
      </a>
    <?php elseif ($_SESSION['perms'] == 'director'): ?>
      <a href="index.php?command=directorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
        Go to the Director Page
      </a>
    <?php endif; ?>

    <a href="group.php?show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-primary">
      Join This Show
    </a>

    <a href="index.php?command=showlist" class="btn btn-outline-secondary">
      Back to Show List
    </a>
  </div>

</main>

</body>
</html>