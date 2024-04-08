
function borrar (id){
    Swal.fire({
        icon: "error",
        title: "¿Borrar?",        
        showCancelButton: true,
        confirmButtonText: "Si",        
      }).then((result) => {        
        if (result.isConfirmed) {
          window.location="user_view.php?txtID="+id;
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
      confirmButtonColor: "#3085d6", 
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
