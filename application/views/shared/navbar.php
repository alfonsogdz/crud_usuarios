<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<style>
    .bg-primary {
        background: #0f0c29;
        /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #24243e, #302b63, #0f0c29);
        /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #24243e, #302b63, #0f0c29);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    }
    .navbar-dark{
        color: #ffff !important;
    }
</style>
<header>
    <nav class="navbar fixed-top navbar-expand-md navbar-dark bg-primary ">
        <a class="navbar-brand" href="#">
            <img src="https://1000marcas.net/wp-content/uploads/2020/03/Logo-21-Pilots.png" width="50" height="30" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav d-flex justify-content-end">
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('User') ?>">Crear Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('comite') ?>">Crear Comité</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
