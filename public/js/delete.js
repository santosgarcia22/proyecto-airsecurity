document.addEventListener("DOMContentLoaded", function () {
  document.body.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-eliminar')) {
      e.preventDefault();

      const btn   = e.target;
      const url   = btn.getAttribute('data-url');
      const token = btn.getAttribute('data-token') || document.querySelector('meta[name="csrf-token"]').content;
      const row   = btn.closest('tr');

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
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(response => {
            if (response.ok) {
              row.style.transition = 'opacity .3s';
              row.style.opacity = '0';
              setTimeout(() => row.remove(), 300);
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
    }
  });
});
