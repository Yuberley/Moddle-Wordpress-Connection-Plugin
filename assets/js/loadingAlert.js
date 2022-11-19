
function loadingAlertGenerateReport() {
  
    Swal.fire({
        title: 'Generando Reporte...',
        html: 'Espere por favor...',
        allowEscapeKey: false,
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading()
        }
      });


   
}

