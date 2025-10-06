<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstrumentosMX</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div class="logo">InstrumentosMX</div>
        <nav>
            <ul>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="nosotros.html">Sobre Nosotros</a></li>
                <li><a href="contacto.html">Contacto</a></li>

                <?php if (isset($_SESSION['usuario'])): ?>
                    <!-- Si el usuario está logueado -->
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                    <li style="color: yellow;">👋 Bienvenido, <?php echo $_SESSION['usuario']; ?></li>
                <?php else: ?>
                    <!-- Si NO hay sesión -->
                    <li><a href="login.html">Iniciar Sesión</a></li>
                    <li><a href="registro.html">Registro</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <div class="overlay">
            <h1>Encuentra tu sonido</h1>
            <p>Instrumentos de calidad al alcance de todos</p>
            <a href="productos.php" class="btn">Explorar Productos</a>
        </div>
    </section>

    <section class="destacados">
        <h2>Productos Destacados</h2>
        <div class="cards">
            <a href="productos.php?categoria=Guitarras" class="card">
                <img src="img/fc9631099e021ce5e1da2588c11bf04b.jpg" alt="Guitarra">
                <h3>Guitarras</h3>
            </a>
            <a href="productos.php?categoria=Bajos" class="card">
                <img src="img/bass-guitar-l60dugeu4f1her06.jpg" alt="Bajos">
                <h3>Bajos</h3>
            </a>
            <a href="productos.php?categoria=Baterias" class="card">
                <img src="img/bateria.jpg" alt="Baterías">
                <h3>Baterías</h3>
            </a>
            <a href="productos.php?categoria=Teclados/Pianos" class="card">
                <img src="img/b2f90feaf29ec3f2d811b28da1d053e0.jpg" alt="Teclado">
                <h3>Teclados/Pianos</h3>
            </a>
            <a href="productos.php?categoria=Violines" class="card">
                <img src="img/violin1.jpg" alt="Violín">
                <h3>Violines</h3>
            </a>
        </div>
    </section>

    <section class="redes-sociales">
        <h2 style="text-align: center;">Síguenos en Nuestras Redes Sociales</h2>
        <ul>
            <li style="text-align: center;"><a href="https://facebook.com" target="_blank">Facebook</a></li>
            <li style="text-align: center;"><a href="https://instagram.com" target="_blank">Instagram</a></li>
            <li style="text-align: center;"><a href="https://twitter.com" target="_blank">Twitter</a></li>
        </ul>
    </section>

    <section class="opiniones">
        <h2 style="text-align: center;">Opiniones de Nuestros Clientes</h2>
        <p style="text-align: center;">"Excelente calidad y servicio" - Juan Pérez</p>
        <p style="text-align: center;">"Los mejores instrumentos que he comprado" - María López</p>
    </section>

    <footer>
        <p>© 2025 InstrumentosMX | Todos los derechos reservados</p>
        <p>Visitas: <span id="contador-visitas">0</span></p>
    </footer>

   <script>
  const hero = document.querySelector('.hero');
  const images = [
    'img/ecenario.jpg',
    'img/guitarraacus.jpg',
    'img/guitarraelect.jpg',
    'img/bateria.jpg',
    'img/piano.jpg',
    'img/violin.jpg'
  ];

  // Cambiar imagen aleatoriamente con transición suave
  function changeBackground() {
    const randomIndex = Math.floor(Math.random() * images.length);
    const newImage = `url(${images[randomIndex]})`;
    hero.style.opacity = 0;
    setTimeout(() => {
      hero.style.backgroundImage = newImage;
      hero.style.opacity = 1;
    }, 800);
  }

  hero.style.transition = "opacity 1.2s ease-in-out, background-image 1.2s ease-in-out";
  changeBackground();
  setInterval(changeBackground, 6000); // cada 6 segundos
</script>

</body>
</html>




