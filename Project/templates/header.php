<!doctype html>
<html lang="en">
  <head>
    <title>Frame</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?=dirname($_SERVER['SCRIPT_NAME']);?>">Navbar</a>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link" href="<?=dirname($_SERVER['SCRIPT_NAME']);?>/hello/Kristina">Hello</a>
            <a class="nav-link active" href="<?=dirname($_SERVER['SCRIPT_NAME']);?>/articles">Articles<span class="sr-only">(current)</span></a>
            <a class="nav-link" href="<?=dirname($_SERVER['SCRIPT_NAME']);?>/article/create">Create article</a>
        </div>
    </div>
    </nav>
    </header>
    <main>
      <div class="container">