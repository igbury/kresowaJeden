<?session_start();?>
<header>
    <nav class="navbar navbar-expand-sm border border-secondary bg-dark navbar-dark fixed-top">
        <div class="container-fluid">
            <h3 class="navbar-text mx-2 my-1">KresowaJeden</h3>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-3 my-1">
                    <a href="<?=INDEX?>" class="btn btn-outline-success">Home</a>
                </li>
                <li class="nav-item mx-3 my-1">
                    <a href="<?=VIEWMENU?>" class="btn btn-outline-success">Menu</a>
                </li>
                <?php if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']): ?>
                    <li class="nav-item mx-3 my-1">
                        <div class="dropend">
                            <a class="btn btn-outline-danger dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                Administracja
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="<?=MODIFYMENU?>">Modyfikuj menu</a></li>
                                <li><a class="dropdown-item disabled" href="#">Zarządzaj pracownikami</a></li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-2 my-1">
                        <?php if(isset($_SESSION['user'])): ?>
                            <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#bookModal1">Rezerwacja</a>
                        <?php else: ?>
                            <a href="#" class="btn btn-outline-secondary disabled" data-bs-toggle="modal" data-bs-target="#bookModal1">Rezerwacja</a>
                        <?php endif; ?>
                    </li>                  
                    <li class="nav-item mx-3 my-1">
                        <a href="<?=CONTACT?>" class="btn btn-outline-success">Kontakt</a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if(isset($_SESSION['user'])): ?>
                    <?php $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                    <li class="nav-item mx-2 my-1">
                        <a href="<?=VIEWCART?>" class="btn btn-outline-light">
                            <i class="bi bi-cart"></i> <?=$count?>
                        </a>
                    </li>
                    <li class="nav-item mx-2 my-1">
                        <a href="<?=VIEWACCOUNT?>" class="btn btn-outline-light">
                            <i class="bi bi-person-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item mx-2 my-1">
                        <a href="<?=LOGOUT?>" class="btn btn-outline-danger">Wyloguj</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-2 my-1">
                        <a href="<?=VIEWCART?>" class="btn btn-outline-light disabled">
                            <i class="bi bi-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item mx-2 my-1">
                        <a href="#" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>