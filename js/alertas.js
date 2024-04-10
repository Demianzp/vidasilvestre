function borrar (id_persona){     
    Swal.fire({      
        icon: "error",
        title: "¿Bor00000rar?",        
        showCancelButton: true,
        confirmButtonText: "Si",        
      }).then((result) => {        
        if (result.isConfirmed) {
          window.location="alumnodelete.php?txtID="+id_persona;
        } 
      });    
}


function cerrar (){
  Swal.fire({
      icon: "question",
      iconColor: 'red',
      title: "¿Desea000000000000 Salir?",        
      showDenyButton: true,
      confirmButtonText: "Si",
      confirmButtonColor: "#000", 
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
