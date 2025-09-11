// delete1.js (ejemplo)
$(document).on('click', '.btn-eliminar', function () {
  const btn   = this;
  const url   = btn.dataset.url;
  const token = btn.dataset.token;

  Swal.fire({
    title: '¿Eliminar?',
    text: 'Esta acción no se puede deshacer.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar'
  }).then(async (r) => {
    if (!r.isConfirmed) return;

    try {
      const resp = await fetch(url, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': token,
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        },
        body: new URLSearchParams({ _method: 'DELETE' })
      });

      // Si algo falló en backend, resp.text() te mostrará el HTML del error
      if (!resp.ok) { console.error(await resp.text()); toastr.error('No se pudo eliminar'); return; }

      const table = $('#tablaPersonas').DataTable();
      table.row($(btn).closest('tr')).remove().draw(false); // <- quita la fila localmente
      toastr.success('Eliminado correctamente');
    } catch (e) {
      console.error(e);
      toastr.error('Error de red');
    }
  });
});
