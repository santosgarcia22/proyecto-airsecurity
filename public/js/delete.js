document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.btn-eliminar').forEach(function(btn){
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            let url = this.getAttribute('data-url');
            let token = this.getAttribute('data-token');
            let row = this.closest('tr');
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el registro permanentemente.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((res) => {
                if (res.isConfirmed) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            row.remove();
                            Swal.fire('Eliminado', 'El registro fue eliminado.', 'success');
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el registro.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Ocurrió un error en la solicitud.', 'error');
                    });
                }
            });
        });
    });
});
