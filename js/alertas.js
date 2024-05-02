function eliminar (id_persona){
  Swal.fire({
      icon: "error",
      title: "¿Borrar?",        
      showCancelButton: true,
      confirmButtonText: "Si",   
      confirmButtonColor: "#007bff",
      cancelButtonColor: '#dc3545',     
    }).then((result) => {        
      if (result.isConfirmed) {
        window.location="alumno_index.php?txtID="+id_persona;
        window.location="profe_index.php?txt2ID="+id_persona;
      } 
    });
}
function cerrar (){
  Swal.fire({
      icon: "question",
      iconColor: 'red',
      title: "¿Desea Salir?",        
      showDenyButton: true,
      confirmButtonText: "Si",
      confirmButtonColor: "#007bff", 
      denyButtonText: "No",
      customClass: {
        confirmButton: 'px-5 ',
        denyButton: 'px-5 ',
      }
    }).then((result) => {        
      if (result.isConfirmed) {
        window.location="logout.php";
      } 
    });    
}
