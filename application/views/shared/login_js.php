<script>
    //$('#ui-view').ajaxLoad();

    $(document).ready(function() {
        Pace.restart()
    }).ready(function() {
        <?php if ($this->session->flashdata('errorMessage')) { ?>
            Swal.fire({
                position: 'top-end',
                icon: 'error',
                title: '<?= $this->session->flashdata('errorMessage') ?>',
                showConfirmButton: false,
                timer: 1800
            })
        <?php } ?>
    });
</script>