<header id="header" class="header" data-scrollto-offset="0">
    <div class="container-fluid d-flex align-items-center justify-content-between">

        <a href="./" class="logo d-flex align-items-center scrollto me-auto me-lg-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1>Portal escrituras<span>.</span></h1>
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="nav-link scrollto" href="./">Início</a></li>
                <li class="dropdown">
                    <a href="#">
                        <span>Serviços</span> <i class="bi bi-chevron-down dropdown-indicator"></i>
                    </a>
                    <ul>
                        <li><a href="busca-escritura">Busca Grátis</a></li>
                        <li><a href="cadastro-do-tabelionato">Solicitação de Escritura</a></li>
                        <?php if ($_SESSION['usuario']) { ?>
                            <li><a href="cadastro-documento">Cadastro de documento</a></li>
                            <li><a href="lista-cadastros">Lista de cadastros</a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="index.html#portfolio">Suporte</a></li>
                <li><a class="nav-link scrollto" href="seja-membro">Seja membro</a></li>
                <li><a class="nav-link scrollto" href="quem-somos">Quem somos</a></li>
                <li><a class="nav-link scrollto" href="contato">Contato</a></li>
                <?php if (!isset($_SESSION['usuario'])) { ?>
                    <li><a class="nav-link scrollto" href="login">Login</a></li>
                <?php } else { ?>
                    <li><a class="nav-link logout" href="#">Sair</a></li>
                <?php } ?>
            </ul>
            <i class="bi bi-list mobile-nav-toggle d-none"></i>
        </nav><!-- .navbar -->
        <a
                href="#"
        ><i class="fa-solid fa-user"></i> <?= $_SESSION['usuario']['nome'] ?>
        </a>
        <!--<a class="btn-getstarted scrollto" href="index.html#about">Cadastre-se</a>-->
    </div>
</header><!-- End Header -->



