var swal_mixin = swal.mixin({
    cancelButtonText: "Cancelar",
    confirmButtonText: "Sí, continuar",
    reverseButtons: true,
    allowOutsideClick: false
});

var swal_mixin_simple = swal.mixin({
    confirmButtonText: "Aceptar",
    allowOutsideClick: false
});

// SWAL ALERT -- Solo con opción de Aceptar
function alert_warning_simple(html) {
  swal_mixin_simple.fire({
      html: html,
      icon: "warning",
  });
}

function alert_error(html, callback) {
  swal_mixin_simple.fire({
      html: html,
      icon: "error",
  }).then(callback);
}

function alert_success(html, callback) {
  swal_mixin_simple.fire({
      html: html,
      icon: "success",
  }).then(callback);
}

// SWAL ALERT -- Con opciones de (Cancelar/Si, continuar)
function alert_warning_primary(html, callback) {
  swal_mixin.fire({
      title: "¿Está seguro?",
      html: html,
      icon: "warning",
      showCancelButton: true,
      cancelButtonColor: '#F64E60',
      confirmButtonColor: '#0BB7AF',
  }).then(callback);
}

function alert_warning_secondary(html, callback) {
  swal_mixin.fire({
      title: "¿Está seguro?",
      html: html,
      icon: "warning",
      showCancelButton: true
  }).then(callback);
}
