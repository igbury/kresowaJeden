<?session_start();?>
<header>
    <nav class="navbar navbar-expand-sm fixed-top">
        <div class="container-fluid px-4">
            <a href="<?=INDEX?>" class="navbar-text text-decoration-none">
                KresowaJeden
            </a>
            <ul class="navbar-nav mx-auto align-items-center">
                <li class="nav-item px-1">
                    <a href="<?=INDEX?>" class="btn btn-outline-success">
                        <i class="bi bi-house-fill me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item px-1">
                    <a href="<?=VIEWMENU?>" class="btn btn-outline-success">
                        <i class="bi bi-three-dots-vertical me-2"></i>Menu
                    </a>
                </li>
                <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                    <li class="nav-item px-1">
                        <div class="dropend">
                            <a class="btn btn-outline-danger dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                Administracja
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?=MODIFYMENU?>">Modyfikuj menu</a></li>
                                <li><a class="dropdown-item disabled" href="#">Zarządzaj pracownikami</a></li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item px-1">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bookModal1">
                                <i class="bi bi-calendar-check me-2"></i>Rezerwacja
                            </a>
                        <?php else: ?>
                            <a href="#" class="btn btn-outline-secondary disabled">
                                <i class="bi bi-calendar-check me-2"></i>Rezerwacja
                            </a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item px-1">
                        <a href="<?=CONTACT?>" class="btn btn-outline-success">
                            <i class="bi bi-telephone-fill me-2"></i>Kontakt
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-3 align-items-center">
                <?php if(isset($_SESSION['user'])): ?>
                    <?php $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                    <li class="nav-item mx-1 my-1 px-1">
                        <a href="<?=VIEWCART?>" class="btn btn-outline-light position-relative">
                            <i class="bi bi-cart"></i>
                            <?php if($count > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill" style="background:var(--kj-green);font-size:.65rem;"><?=$count?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item px-1">
                        <a href="<?=VIEWACCOUNT?>" class="btn btn-outline-light">
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item px-1">
                        <a href="<?=LOGOUT?>" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Wyloguj
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-1 my-1 px-1">
                        <a href="<?=VIEWCART?>" class="btn btn-outline-light disabled">
                            <i class="bi bi-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item mx-1 my-1 px-1">
                        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="bi bi-box-arrow-in-left me-1"></i>Zaloguj
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
    <?php include BOOKMODALS; ?>