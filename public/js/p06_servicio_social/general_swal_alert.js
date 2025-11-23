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

function alert_loading() {
    swal.fire({
        title: '<button class="btn btn-white spinner spinner-primary spinner-right"><h6 class="m-auto">Espere un momento ...</h6></button>',
        showConfirmButton: false,
        allowOutsideClick: false
    });
    $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0)');
}

function alert_time_close(tiempo){
    setTimeout(function(){
        swal.close();
    }, tiempo);
}