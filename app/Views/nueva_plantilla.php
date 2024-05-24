<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ratita Sporting - Tu tienda de deportes</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <style>
    /* Add your custom styles here */
    body {
      background-color: #f8f9fa;
    }

    .carousel-indicators li {
      background-color: #343a40;
      border-radius: 50%;
    }

    .carousel-indicators li.active {
      background-color: #ff9900;
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Ratita Sporting</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Ofertas</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contacto</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="assets/img/banner1.jpg" class="d-block w-100" alt="Banner 1">
                <div class="carousel-caption">
                  <h5>¡Bienvenido a Ratita Sporting!</h5>
                  <p>Encuentra todo lo que necesitas para tu deporte favorito.</p>
                  <a href="#" class="btn btn-primary">Comprar ahora</a>
                </div>
              </div>
              <div class="carousel-item">
                <img src="assets/img/banner2.jpg" class="d-block w-100" alt="Banner 2">
                <div class="carousel-caption">
                  <h5>Ofertas increíbles</h5>
                  <p>No te pierdas nuestras ofertas en artículos deportivos.</p>
                  <a href="#" class="btn btn-secondary">Ver ofertas</a>
                </div>
              </div>
              <div class="carousel-item">
                <img src="assets/img/banner3.jpg" class="d-block w-100" alt="Banner 3">
                <div class="carousel-caption">
                  <h5>Envío gratis en compras superiores a $500</h5>
                  <p>¡Aprovecha esta promoción!</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample
