<nav class="navbar navbar-expand-lg" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php" id="logo"><span id="span1">C</span>ORPORACION<span>MILO</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span><img src="./images/imagenes/menu.png" alt="" width="30px"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.html">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Productos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorias
                    </a>
                    <ul class="dropdown-menu" style="background-color: rgb(67, 0, 86);">
                        <li><a class="dropdown-item" href="#">PROCESADORES</a></li>
                        <li><a class="dropdown-item" href="#">MOTHERBOARD</a></li>
                        <li><a class="dropdown-item" href="#">MEMORIAS RAM</a></li>
                        <li><a class="dropdown-item" href="#">ALMACENAMIENTO</a></li>
                        <li><a class="dropdown-item" href="#">FUENTES DE PODER</a></li>
                        <li><a class="dropdown-item" href="#">CASES</a></li>
                        <li><a class="dropdown-item" href="#">COOLER</a></li>
                        <li><a class="dropdown-item" href="#">PERIFERICOS</a></li>
                    </ul>
                </li>
            </ul>
            <form class="d-flex" id="seach">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-sm" href="checkout.php">
                        <i class="fas fa-shopping-cart"></i><span id="num_cart" class="badge bg-secondary"><?php echo $num_cart; ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <div class="dropdown">
                        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="btn_session" data-bs-toggle="dropdown" 
                        aria-expanded="false">
                        <i class="fa-sharp fa-regular fa-user" style="color: #74C0FC;"></i> &nbsp; <?php echo $_SESSION['user_name']; ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="btn_session">
                            <li><a class="dropdown-item" href="exit.php">Salir</a></li>
                        </ul>
                        </div>
                    <?php } else { ?>
                        <a class="nav-link btn-sm" href="login.php">
                            <i class="fa-solid fa-right-to-bracket"></i> Iniciar Sesion
                        </a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
