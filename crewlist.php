<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Crew List</title>
</head>

<body class="bg-light">
<div class="container my-5">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h1>Crew List</h1>
      <p class="text-muted mb-0">
        Show: <?= htmlspecialchars($show["title"]) ?>
      </p>
    </div>

    <a href="index.php?command=directorpage&show_id=<?= htmlspecialchars($show["show_id"]) ?>" class="btn btn-outline-secondary">
      Back to Director Page
    </a>
  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="h5 mb-3">Crew Members and Tasks</h2>

      <table class="table table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>User ID</th>
            <th>Crew Member</th>
            <th>Assigned Task</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($crewList as $crew): ?>
            <tr>
              <td><?= htmlspecialchars($crew["user_id"]) ?></td>
              <td><?= htmlspecialchars($crew["username"]) ?></td>
              <td>
                <?= htmlspecialchars($crew["task"] ?? "No task assigned") ?>

                <!-- EDIT BUTTON -->
                <button 
                  type="button" 
                  class="btn btn-sm btn-outline-primary ms-2"
                  data-bs-toggle="modal"
                  data-bs-target="#editTaskModal<?= htmlspecialchars($crew["user_id"]) ?>">
                  Edit
                </button>

                <button 
                    type="submit" 
                    class="btn btn-sm btn-outline-danger ms-2"
                    onclick="return confirm('Delete this task?')">
                    Delete
                </button>

                <!-- MODAL -->
                <div class="modal fade" id="editTaskModal<?= htmlspecialchars($crew["user_id"]) ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <form method="post" action="index.php?command=assigncrewtask">
                        <div class="modal-header">
                          <h5 class="modal-title">
                            Edit Task for <?= htmlspecialchars($crew["username"]) ?>
                          </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                          <input type="hidden" name="show_id" value="<?= htmlspecialchars($show["show_id"]) ?>">
                          <input type="hidden" name="user_id" value="<?= htmlspecialchars($crew["user_id"]) ?>">

                          <label class="form-label">Assigned Task</label>
                          <input
                            type="text"
                            name="task"
                            class="form-control"
                            value="<?= htmlspecialchars($crew["task"] ?? "") ?>"
                            placeholder="e.g. lights, camera, costumes">
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cancel
                          </button>
                          <button type="submit" class="btn btn-primary">
                            Save Changes
                          </button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <?php if (empty($crewList)): ?>
        <p class="text-muted">No crew members found for this show.</p>
      <?php endif; ?>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>