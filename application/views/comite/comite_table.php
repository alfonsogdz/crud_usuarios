<?php
defined('BASEPATH') or exit('No direct script access allowed');



$comites = array(
    array(
        'comite_id' => 1,
        'comite_name' => 'Prueba'
    ),
    array(
        'comite_id' => 3,
        'comite_name' => 'Prueba 3'

    )
)

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comites</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
        .main-page {
            margin-top: 1rem !important;
            margin-bottom: 1rem !important;
        }
    </style>
</head>

<body>


    <div class="container mt-2 main-page">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Comités</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" id="btnCreateComite" type="button"> <i class="fa fa-plus"></i> Crear Comité</button>

                </div>

            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <h3>Comités</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-sm"  id="tableComite">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Fecha Inicio</th>
                                <th scope="col">Fecha Termino</th>
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Crear Comité</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label for="comiteName" class="col-sm-2 col-form-label">Nombre</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="comites_id" style="display: none ;">
                                    <input type="text" class="form-control" id="comiteName">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Fecha inicio a fecha termino" id="fecha">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="estatus" class="col-sm-2 col-form-label">Estatus</label>
                                <div class="col-sm-10">
                                    <select class="form-control" title="Seleccione programa" data-live-search="true" name="estatus" id="estatus">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        <option value="3">Cancelado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="programa" class="col-sm-2 col-form-label">Programa</label>
                                <div class="col-sm-10">
                                    <select class="form-control" title="Seleccione programa" data-live-search="true" name="programa" id="programa">
                                        <option value="1">Test1</option>
                                        <option value="2">Test2</option>
                                        <option value="3">Test3</option>
                                        <option value="4">Test4</option>
                                        <option value="5">Test5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="button" id="modalAction" class="btn btn-primary" onclick=""><i class="fa fa-save"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bubbly-bg@1.0.0/dist/bubbly-bg.js"></script>

        <?php $this->load->view('comite/comite_table_js') ?>
</body>

</html>