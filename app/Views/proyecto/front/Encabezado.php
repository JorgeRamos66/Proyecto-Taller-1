

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url ('./assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url ('./assets/css/bootstrap.min.css') ?>" rel="stylesheet" integrity="" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap CSS -->
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title><?=$titulo?></title>
</head>
<body class="">
<?php
$session = session();
$nombre = $session->get('nombre');
$apellido = $session->get('apellido');
// Obtener la URL actual
$currentUrl = current_url();
?>
     <video id="background-video" autoplay loop muted poster="assets/img/bg-video3pic.png">
        <source src=" <?php echo base_url ('./assets/video/bg-video4.mp4') ?>" type="video/mp4">
      </video>
    <header>
        <h1 class="header1">
            <?php if (($nombre == 'Clelia Raquel') && ($apellido == 'Canteros Loebarth')): ?>
                <a class="navbar-brand mx-0 btn rounded-bottom btn-outline-secondary my-1 <?= $currentUrl == base_url('/') ? 'active' : '' ?>" href="<?php echo base_url('/');?>"><img src="<?php echo base_url ('./assets/img/ratitaojonamoño.png') ?>" class="" width="100%" height="90px" alt=""></a>
            <?php else: ?>
                <a class="navbar-brand mx-0 btn rounded-bottom btn-outline-secondary my-1 <?= $currentUrl == base_url('/') ? 'active' : '' ?>" href="<?php echo base_url('/');?>"><img src="<?php echo base_url ('./assets/img/ratita_ojona.webp') ?>" class="" width="100%" height="90px" alt=""></a>
            <?php endif; ?>
            <span class="titulo" style="color: white;">🆁🅰🆃🅸🆃🅰 🆂🅿🅾🆁🆃🅸🅽🅶</span>	
        </h1>
    </header>