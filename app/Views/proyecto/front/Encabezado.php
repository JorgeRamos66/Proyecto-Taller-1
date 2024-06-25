

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url ('./assets/css/miestilo.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url ('./assets/css/bootstrap.min.css') ?>" rel="stylesheet" integrity="" crossorigin="anonymous">
    <title><?=$titulo?></title>
</head>
<body class="">
<?php
$session = session();
$nombre = $session->get('nombre');
$apellido = $session->get('apellido');
?>
     <video id="background-video" autoplay loop muted poster="assets/img/bg-video3pic.png">
        <source src=" <?php echo base_url ('./assets/video/bg-video4.mp4') ?>" type="video/mp4">
      </video>
    <header>
        <h1 class="header1">
            <?php if (($nombre == 'Clelia Raquel') && ($apellido == 'Canteros Loebarth')): ?>
                <a class="navbar-brand mx-0 btn rounded-bottom btn-outline-secondary my-1" href="<?php echo base_url('/');?>"><img src="<?php echo base_url ('./assets/img/ratitaojonamoño.png') ?>" class="" width="100%" height="90px" alt=""></a>
            <?php else: ?>
                <a class="navbar-brand mx-0 btn rounded-bottom btn-outline-secondary my-1" href="<?php echo base_url('/');?>"><img src="<?php echo base_url ('./assets/img/ratita_ojona.webp') ?>" class="" width="100%" height="90px" alt=""></a>
            <?php endif; ?>
            <span class="titulo" style="color: white;">🆁🅰🆃🅸🆃🅰 🆂🅿🅾🆁🆃🅸🅽🅶</span>	
        </h1>
    </header>