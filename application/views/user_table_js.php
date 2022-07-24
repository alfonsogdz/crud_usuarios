<?php

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

<script>
    var table;
    var users = [];

    $(document).ready(function() {
        table();

        $("#btnCreateUser").on('click', function() {
            $("#modalAction").attr("onClick", "insertUser()");
            $("#user_creation_form").trigger('reset');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Crear Usuario");
            $('#selComite').val('');
            $('#selComite').selectpicker('refresh');
            $('#selStatus').val('');
            $('#selStatus').selectpicker('refresh');
            $("#staticBackdrop").modal();
        });

    });

    function insertUser() {
        var data = decodeURIComponent($("#user_creation_form").serialize());
        var commite = "";
        var array = $('#selComite').val();
        for (var i = 0; i < array.length; i++) {
            commite += array[i];
            if (i != array.length - 1) {
                commite += "-";
            }
        }

        var ruta = window.location.origin + "/crud_data_table/User/insertUser?" + data + "&commite=" + commite;

        $.ajax({
            url: ruta,
            type: 'get',
            dataType: 'json',
            data: {
                'data': ""
            },
            success: function(response) {
                $("#staticBackdrop").modal('hide');
                Swal.fire(
                    'Exito',
                    'El usuario se ha creado con exito',
                    'success'
                )
                table.DataTable().ajax.reload();
            },
            error: function(xhr, status) {
                Swal.fire(
                    'Error',
                    'Disculpe las molestias existio un error',
                    'error'
                )

            }
        });
    }

    function passwordEquals(password, confirmPassword) {
        if (password == confirmPassword) {
            alert('Son iguales');
        } else {
            alert('no son iguales')
        }

    }
    $(document).on("click", "#btnEditar", function() {
        fila = $(this).closest("tr");
        user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

        $.ajax({
            url: '<?= site_url('user/getUserById') ?>',
            type: 'post',
            dataType: 'json',
            data: {
                'idUsuario': user_id
            },
            success: function(resp) {
                $("#user_id").val(resp.data[0].idUsuario)
                $("#nameUser").val(resp.data[0].nombre);
                $("#txtProcedencia").val(resp.data[0].procedencia)
                $("#txtUser").val(resp.data[0].usuario);
                $("#password").val(resp.data[0].contrasenia)
                $("#confirmPassword").val(resp.data[0].contrasenia)
                //$("#confirmPassword").val(resp.data[0].contrasenia)
                //$("#selComite").selectpicker('val', resp.data.comite);
                $("#lastName").val(resp.data[0].apellido);
                $("#selStatus").selectpicker('val', resp.data[0].estatus);

                ruta = window.location.origin + "/crud_data_tables/User/";
                $.ajax({
                    type: 'POST',
                    url: '<?= site_url('user/getCommitesByUser') ?>',
                    data: {
                        'id': user_id
                    },
                    dataType: "json",

                    success: function(cons) {
                        var values = [];
                        for (var i = 0; i < cons.length; i++) {
                            values.push(cons[i].comite_id);
                        }

                        $('#selComite').val(values);
                        $('#selComite').selectpicker('refresh');
                        $("#staticBackdrop").modal('show');
                    },
                    error: function(error) {
                        Swal.fire(
                            'Error',
                            'Disculpe las molestias existio un error',
                            'error'
                        )

                    }

                })


                $(".modal-header").css("background-color", "#007bff");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Editar Usuario");
                //$('#staticBackdrop').modal('show');
                $("#modalAction").attr("onClick", "updateUser(" + user_id + ")");
                $("#staticBackdrop").modal();

            },
            error: function(error) {
                Swal.fire(
                    'Error',
                    'Disculpe las molestias existio un error',
                    'error'
                )
            }
        });
    });

    function updateUser(id) {
        var uri_dec = decodeURIComponent($("#user_creation_form").serialize());

        var ruta = window.location.origin + "/crud_data_table/User/";

        var commite = "";
        var array = $('#selComite').val();
        for (var i = 0; i < array.length; i++) {
            commite += array[i];
            if (i != array.length - 1) {
                commite += "-";
            }
        }

        Swal.fire({
            title: '¿Desea actulizar el usuario?',
            text: "Podra cambiar la información en cualquier momento",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: ruta + "updateUser?" + uri_dec + "&commite=" + commite,
                    type: 'get',
                    data: {
                        'data': ""
                    },
                    dataType: "json",
                    success: function(resp) {
                        $("#staticBackdrop").modal('hide');
                        Swal.fire(
                            'Actualizado',
                            'El usuario se ha actualizado con exito',
                            'success'
                        );
                        table.DataTable().ajax.reload();
                    },
                    error: function(xhr, error) {
                        Swal.fire(
                            'Error',
                            'Disculpe las molestias existio un error',
                            'error'
                        )
                    }
                })
            }
        })


    }

    $(document).on("click", "#btnBorrar", function() {
        fila = $(this).closest("tr");
        user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

        Swal.fire({
            title: '¿Desea inhabilitar el usuario?',
            text: "Podra habilitarlo en cualquier momento",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url('user/deleteUser') ?>',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        'idUsuario': user_id
                    },
                    success: function(resp) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'El usuario se ha desactivado',
                        })
                        table.DataTable().ajax.reload();
                        //table.columns.adjust().draw();

                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'error',
                            text: 'Disculpe, existio un problema',
                        })
                    }
                });

            }
        })


    });

    function table() {
        table = $("#tableUser").dataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json' // https://datatables.net/plug-ins/i18n/Spanish
            },
            ajax: {
                url: '<?= site_url('user/getUsers') ?>',
                type: 'post',
                dataSrc: "",
            },
            destroy: true,
            columns: [{
                    data: 'idUsuario'
                },
                {
                    data: 'nombre'
                },
                {
                    data: 'procedencia'
                },
                {
                    data: 'usuario'
                },
                {
                    data: 'estatus'
                },
                {
                    defaultContent: '<button id="btnEditar" class="btn btn-primary mr-1"><i class="fa fa-pencil"></i></button><button id="btnBorrar" class="btn btn-danger"><i class="fa fa-trash"></i></button>'
                }
            ]
        })
    }
</script>