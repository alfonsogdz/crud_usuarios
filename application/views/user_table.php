<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <style>
        .main-page {
            margin-top: 4rem !important;
            margin-bottom: 4rem !important;
        }
    </style>
</head>

<body>

    <main role="main" class="container main-page">
        <div class="card">
            <div class="card-header">
                <h4>Usuarios</h4>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" id="btnCreateUser" type="button"> <i class="fa fa-user-plus"></i> Agregar usuario</button>
            </div>

        </div>

        <div class="card mt-2">
            <div class="card-header">
                <h3>Usuarios</h3>
            </div>
            <div class="card-body">
                <table class="table" id="tableUser">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Procedencia</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Estatus</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Agregar Usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="user_creation_form">
                            <div class="row">
                                <input type="text" name="user_id" id="user_id" style="display: none;">
                                <div class="form-group col-lg-4 col-md-3 col-sm-4">
                                    <label for="nameUser">Nombre(s)</label>
                                    <input type="text" class="form-control" name="nameUser" id="nameUser">
                                </div>
                                <div class="form-group col-lg-4 col-md-3 col-sm-4">
                                    <label for="lastName">Apellido(s)</label>
                                    <input type="text" class="form-control" name="lastName" id="lastName">
                                </div>
                                <div class="form-group col-lg-4 col-md-3 col-sm-4">
                                    <label for="txtProcedencia">Procedencia</label>
                                    <input type="text" class="form-control" name="txtProcedencia" id="txtProcedencia">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label for="txtUser">Usuario</label>
                                    <input type="text" class="form-control" name="txtUser" id="txtUser">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-sm-4">
                                    <label for="confirmPassword">Confirmar contraseña</label>
                                    <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label for="selComite">Comite al que pertence</label>
                                    <select name="selComite" id="selComite" class="form-control selectpicker" title="-- Seleccione --" multiple>
                                        <?php foreach ($comites as $key) { ?>
                                            <option value="<?= $key['comites_id'] ?>"><?= $key['comites_nombre'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <label for="selStatus">Estatus</label>
                                    <select name="selStatus" id="selStatus" class="form-control selectpicker" title="Seleccione">
                                        <option value="A">Activo</option>
                                        <option value="I">Inactivo</option>
                                    </select>

                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" id="modalAction" class="btn btn-primary" onclick=""><i class="fa fa-save"></i></button>
                    </div>
                    </form>
                </div>
            </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>


    <?php $this->load->view('user_table_js') ?>
</body>

</html>