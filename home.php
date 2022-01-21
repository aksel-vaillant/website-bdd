<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<?php include ('components/menu.php'); ?>

<div class="container d-flex justify-content-center" style="height:80vh;">
  <div class="row align-items-center">
    <div class="col-6">
      <form action="forms.php" method="post" class="row">
          <div class="form-group row mb-4">  
            <label for="codeclient">ID or name of client</label>
            <input type="text" class="form-control mb-5" name="codeclient" placeholder="17-SPR-0001 or Didier Raoul">

            <input type="submit" class="btn btn-primary" name="button" value="Search a client">
          </div>
      </form>
    </div>
    <div class="col-6">
      <form class="row">
        <div class="form-group row mb-4">  
          <label for="dataClient">ID command</label>
          <input type="text" class="form-control mb-5" name="dataClient" placeholder="21012022-CMD-C0001">
          
          <input type="submit" class="btn btn-primary" name="button" value="Search a command">
        </div>
      </form>  
    </div>

  </div>    
</div>
    
</body>
</html>

