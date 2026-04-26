<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./signup.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Select Group</title>
  </head>


  
  <body class="bg-secondary">
    <div class = "text-center">
    <h1 class="page-title bg-secondary">Choose Your Group!</h1>
    </div>
    <div class="row my-5 align items-center justify-content-center bs-secondary-color">
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="cast_group_image.jpg" class="card-img-top" alt="cast_photo">
        <div class="card-body">
          <h5 class="card-title">Cast</h5>
          <p class="card-text">“Movies will make you famous; Television will make you rich; But theatre will make you good.” -Terrence Mann</p>
          <form action="index.php?command=selectgroup" method="POST">
            <input type="hidden" name="role" value="actor">
            <button type="submit" class="btn btn-secondary">Select</button>
          </form>
        </div>
      </div>
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="crew_group_image.jpg" class="card-img-top" alt="crew_photo">
        <div class="card-body">
          <h5 class="card-title">Crew</h5>
          <p class="card-text">“At the end of the day, give up your worries and give thanks for the journey.” – Ben Vereen</p>
          <form action="index.php?command=selectgroup" method="POST">
            <input type="hidden" name="role" value="crew">
            <button type="submit" class="btn btn-secondary">Select</button>
          </form>
        </div>
      </div>
      <div class="card text-bg-dark mb-3" style="width: 18rem;">
        <img src="director_group_image.jpg" class="card-img-top" alt="director_photo">
        <div class="card-body">
          <h5 class="card-title">Director</h5>
          <p class="card-text">“Unless you learn how to be in your head, you’ll never learn how to create.” – Lin-Manuel Miranda</p>
          <form action="index.php?command=selectgroup" method="POST">
            <input type="hidden" name="role" value="director">
            <button type="submit" class="btn btn-secondary">Select</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>