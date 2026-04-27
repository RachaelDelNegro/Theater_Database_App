<?php
$show_id = $_GET["show_id"] ?? null;

if (!$show_id) {
    die("No show selected.");
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./signup.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Select Group</title>
  </head>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  
  <body class="bg-light">
    <div class="text-start">
        <a href="show_list.html" class="btn btn-sm btn-dark">
            Go back to Show List
        </a>
    </div>
    <div class = "text-center">
    <h1 class="page-title">Select Your Group!</h1>
    </div>
    <div class="row my-5 align items-center justify-content-center bs-secondary-color">
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="cast_group_image.jpg" class="card-img-top" alt="cast_photo">
        <div class="card-body">
          <h5 class="card-title">Cast</h5>
          <p class="card-text">“Movies will make you famous; Television will make you rich; But theatre will make you good.” -Terrence Mann</p>
            <input type="hidden" name="show_id" value="<?= $show_id ?>">
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Select
            </button>    
        </div>
      </div>
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="crew_group_image.jpg" class="card-img-top" alt="crew_photo">
        <div class="card-body">
          <h5 class="card-title">Crew</h5>
          <p class="card-text">“At the end of the day, give up your worries and give thanks for the journey.” – Ben Vereen</p>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                Select
            </button>    
        </div>
      </div>
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="director_group_image.jpg" class="card-img-top" alt="director_photo">
        <div class="card-body">
          <h5 class="card-title">Director</h5>
          <p class="card-text">“Unless you learn how to be in your head, you’ll never learn how to create.” – Lin-Manuel Miranda</p>
            <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal3">
                Select
            </button>    
        </div>
      </div>
    </div>
    <!-- Modal (Cast) -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Join Cast?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Do you want to join this group?
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
              </button>
              <!-- Add userID to Cast table and take them to the cast view landing page -->
            <form action="index.php?command=selectgroup" method="POST">
              <input type="hidden" name="show_id" value="<?= htmlspecialchars($show_id) ?>">
              <input type="hidden" name="role" value="actor">
              <button type="submit" class="btn btn-success">Join Cast!</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- Modal (Crew) -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Join Crew?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Do you want to join this group?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
              </button>
              <!-- Add userID to Crew table and take them to the crew view landing page -->
              <form action="index.php?command=selectgroup" method="POST">
                <input type="hidden" name="show_id" value="<?= htmlspecialchars($show_id) ?>">
                <input type="hidden" name="role" value="crew">
                <button type="submit" class="btn btn-success">Join Crew!</button>
              </form>
        </div>
    </div>
    </div>

    <!-- Modal (Director) -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Join Director?</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Do you want to join this group?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Close
              </button>
              <!-- Add userID to Director table and take them to the director view landing page -->
              <form action="index.php?command=selectgroup" method="POST">
                <input type="hidden" name="show_id" value="<?= htmlspecialchars($show_id) ?>">
                <input type="hidden" name="role" value="director">
                <button type="submit" class="btn btn-success">Join Director!</button>
              </form>
        </div>
        </div>
    </div>
    </div>
  </body>
</html>