// Esperar a que el DOM esté listo
$(document).ready(function() {
    // Evento click para los botones de eliminar
    $('.btn-eliminar').on('click', function(e) {
        e.preventDefault();

        let button = $(this);
        let id = button.data('id');
        // Aquí ajusta la URL a tu ruta de eliminación
        let url = '/admin/acceso/' + id;

        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esto.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX para eliminar
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        Swal.fire(
                            '¡Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        );
                        // Opcional: remover la fila de la tabla
                        button.closest('tr').remove();
                    },
                    error: function() {
                        Swal.fire(
                            'Error',
                            'No se pudo eliminar el registro.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
