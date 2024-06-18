
<?php if(session()->getFlashdata('msg')):?>
<div class=" d-flex mx-6 justify-content-center">
  <div class="alert alert-info alert-dismissible fade show" style="color: black; text-shadow: none;" role="alert">
    <?= session()->getFlashdata('msg')?>
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
  
<?php endif;?>
<div class="container">
    <div class="green-background"></div>
    <div class="row justify-content-center">
        <div class="col-lg-6 mx-0 px-0">
            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="assets\img\botines3.png" class="" alt="...">
                    <div class="carousel-caption d-none d-md-block p-0 m-0 badge text-justify text-wrap" style="color: black;">                
                        <h5>Domina el juego con los botines de fútbol más innovadores del mercado.</h5>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="assets\img\pelota.jpg" class="" alt="...">
                    <div class="carousel-caption d-none d-md-block p-0 m-0 badge text-justify text-wrap" style="color: black;">
                      <h5>Siente la pasión del fútbol con las pelotas más duraderas y resistentes del mercado.</h5>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="assets\img\canilleras2.jpg" class="" alt="...">
                    <div class="carousel-caption d-none d-md-block p-0 m-0 badge text-justify text-wrap" style="color: black;">
                      <h5>Protege tus piernas de los impactos y lesiones con las canilleras más cómodas y seguras del mercado.</h5>
                    </div>
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon bg-dark img-circle" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>
        
        <div class="col-lg-6 bg-black bg-opacity-75 mx-0 border-black container my-2 my-xl-0 my-lg-0">
            <div class="row-center desc hover_show_full">
                <p>En el mundo dinámico del deporte, Ratita Sporting emerge como un faro de entusiasmo y dedicación,
                     satisfaciendo las necesidades de atletas de todas las edades y niveles. El nombre de nuestra compañía,
                      "Ratita Sporting", encarna la agilidad, la resistencia y la pasión que son las señas de identidad del
                       verdadero espíritu deportivo. Creemos que cada individuo posee el potencial para la grandeza, y nuestra
                        misión es empoderarlos para que alcancen sus aspiraciones atléticas.</p>
            </div>
            <div class="row-center desc">
                <p>En Ratita Sporting, vamos más allá de simplemente proporcionar artículos deportivos de alta calidad.
                     Cultivamos una comunidad vibrante de atletas, entrenadores y entusiastas, fomentando una pasión compartida
                      por los deportes que amamos. Nuestro personal capacitado está comprometido a brindar orientación personalizada,
                       asegurando que cada cliente encuentre el equipo perfecto para satisfacer sus necesidades y objetivos únicos.</p>
            </div>
    </div>
</div>
<section class="container mx-0 my-2 text-justify fs-6 desc">
    <div class="row mx-auto">
        <div class="col-lg-4">
            <div class="card my-2 bg-black bg-opacity-75 text-white container">
                <h2 style="text-align: center;">Botines de fútbol:</h1>
                <ul>
                    <li><span class="fw-bold">Tecnología de punta:</span> Diseñados con la tecnología más avanzada para brindarte el máximo rendimiento en la cancha.</li>
                    <li><span class="fw-bold">Comodidad inigualable:</span> Hechos con materiales transpirables y ligeros que se ajustan a tu pie como un guante.</li>
                    <li><span class="fw-bold">Agarre excepcional:</span> Suela con tacos estratégicamente ubicados para darte un agarre y una tracción incomparables en cualquier terreno de juego.</li>
                    <li><span class="fw-bold">Estilos para todos:</span> Elige entre una amplia variedad de colores y diseños para que reflejes tu estilo único en la cancha.</li>
                </ul>
                <p class="fst-italic">¡Lleva tu juego al siguiente nivel con nuestros botines de fútbol!</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-2 bg-black bg-opacity-75 text-white container">
                <h2 style="text-align: center;">Pelotas de fútbol:</h1>
                <ul>
                    <li><span class="fw-bold">Construcción de alta calidad:</span> Fabricadas con materiales de primera línea que garantizan una durabilidad excepcional.</li>
                    <li><span class="fw-bold">Vuelo preciso:</span> Diseñadas para ofrecer un vuelo estable y preciso en cada tiro.</li>
                    <li><span class="fw-bold">Tacto perfecto:</span> Su textura suave te permite controlar el balón con facilidad.</li>
                    <li><span class="fw-bold">Para todos los niveles:</span> Disponibles en diferentes tamaños y niveles de rendimiento para que encuentres la pelota perfecta para tu juego.</li>
                </ul>
                <p class="fst-italic">¡Experimenta la emoción del fútbol real con nuestras pelotas!</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card my-2 bg-black bg-opacity-75 text-white container">
                <h2 style="text-align: center;">Canilleras de fútbol:</h1>
                <ul>
                    <li><span class="fw-bold">Diseño ergonómico:</span> Se ajustan perfectamente a tu pierna para brindar una protección óptima.</li>
                    <li><span class="fw-bold">Materiales resistentes:</span> Fabricadas con materiales de alta resistencia que absorben los impactos.</li>
                    <li><span class="fw-bold">Ligereza y ventilación:</span> Diseño ligero y ventilado que te permite mantenerte fresco y cómodo durante el juego.</li>
                    <li><span class="fw-bold">Para todas las edades:</span> Disponibles en diferentes tamaños para que encuentres las canilleras perfectas para ti.</li>
                </ul>
            <p class="fst-italic">¡Experimenta la emoción del fútbol real con nuestras pelotas!</p>
            </div>
            
        </div>
</section>