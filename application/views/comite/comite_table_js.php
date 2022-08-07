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

    bubbly({
        colorStart: '#d5d5d5',
        colorStop: '#d5d5d5',
        bubbles: 400,
        blur: 1,
        compose: 'source-over',
        bubbleFunc: () => `hsla(${200 + Math.random() * 50}, 100%, 50%, .3)`,
        angleFunc: () => Math.random() > 0.5 ? Math.PI : 2 * Math.PI,
        velocityFunc: () => 1 + Math.random() * 10,
        radiusFunc: () => Math.random() * 5
    });

    $(document).ready(function() {
        table();
        //DPR_CONFIG['autoUpdateInput'] = false;
        $("#fecha").daterangepicker({
            autoUpdateInput: false
        });
        $("#fecha").on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' a ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $("#btnCreateComite").on('click', function() {
            $("#modalAction").attr("onClick", "insertComite()");
            $("#user_creation_form").trigger('reset');
            $(".modal-header").css("background-color", "#007bff");
            $(".modal-header").css("color", "white");
            $(".modal-title").text("Crear Comite");
            $('#selComite').val('');
            $('#selComite').selectpicker('refresh');
            $('#selStatus').val('');
            $('#selStatus').selectpicker('refresh');
            $("#staticBackdrop").modal();
        });

    });

    function insertComite() {
        name = $("#comiteName").val();
        fecha_inicio = $("#fecha").val().split(" a ")[0];
        fecha_fin = $("#fecha").val().split(" a ")[1] + ' 23:59:59';
        estatus = $("#estatus").val();
        programa = $("#programa").val();


        console.log(fecha_inicio);
        console.log(fecha_fin);

        data = {
            'comites_nombre': name,
            'estatus_id': estatus,
            'fecha_inicio': fecha_inicio,
            'fecha_termino': fecha_fin,
            'programa_id': programa
        };

        $.ajax({
            url: "<?= site_url('comite/insertComite') ?>",
            type: 'post',
            dataType: 'json',
            data: {
                'data': data
            },
            success: function(response) {
                $("#staticBackdrop").modal('hide');
                Swal.fire(
                    'Exito',
                    'El Comite se ha creado con exito',
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
        comites_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

        $.ajax({
            url: '<?= site_url('comite/getComiteById') ?>',
            type: 'post',
            dataType: 'json',
            data: {
                'comites_id': comites_id
            },
            success: function(resp) {
                console.log(resp);
                $("#comites_id").val(resp.data[0].comites_id)
                $("#comiteName").val(resp.data[0].comites_nombre);
                $("#fecha").val(resp.data[0].fecha_inicio + " a " + resp.data[0].fecha_termino);
                //$("#confirmPassword").val(resp.data[0].contrasenia)
                //$("#selComite").selectpicker('val', resp.data.comite);
                $("#estatus").val(resp.data[0].estatus_id);
                $("#programa").val(resp.data[0].programa_id);

                $(".modal-header").css("background-color", "#007bff");
                $(".modal-header").css("color", "white");
                $(".modal-title").text("Editar Comite");
                //$('#staticBackdrop').modal('show');
                $("#modalAction").attr("onClick", "updateUser(" + comites_id + ")");
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
        id = $("#comites_id").val();
        name = $("#comiteName").val();
        fecha_inicio = $("#fecha").val().split(" a ")[0];
        fecha_fin = $("#fecha").val().split(" a ")[1] + ' 23:59:59';
        estatus = $("#estatus").val();
        programa = $("#programa").val();

        console.log(id);
        data = {
            'comites_nombre': name,
            'estatus_id': estatus,
            'fecha_inicio': fecha_inicio,
            'fecha_termino': fecha_fin,
            'programa_id': programa
        };

        Swal.fire({
            title: '¿Desea actulizar el Comite?',
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
                    url: "<?= site_url('Comite/updateComite') ?>",
                    type: 'post',
                    data: {
                        'data': data,
                        'id': id
                    },
                    dataType: "json",
                    success: function(resp) {
                        if (resp.ok) {
                            $("#staticBackdrop").modal('hide');
                            Swal.fire(
                                'Actualizado',
                                'El Comite se ha actualizado con exito',
                                'success'
                            );
                            table.DataTable().ajax.reload();

                        }

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
        comites_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

        Swal.fire({
            title: '¿Desea inhabilitar el Comite?',
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
                        'comites': user_id
                    },
                    success: function(resp) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Exito',
                            text: 'El Comite se ha desactivado',
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
        table = $("#tableComite").dataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json' // https://datatables.net/plug-ins/i18n/Spanish
            },
            ajax: {
                url: '<?= site_url('Comite/getComites') ?>',
                type: 'post',
                dataSrc: "",
            },
            destroy: true,
            columns: [{
                    data: 'comites_id'
                },
                {
                    data: 'comites_nombre'
                },
                {
                    data: 'fecha_inicio'
                },
                {
                    data: 'fecha_termino'
                },
                {
                    data: 'estatus_id'
                },
                {
                    defaultContent: '<button id="btnEditar" class="btn btn-primary mr-1"><i class="fa fa-pencil"></i></button>'
                }
            ]
        })
    }
</script>