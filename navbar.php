<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instituto Superior Vida Silvestre</title>
  <link rel="shortcut icon" href="img/LOGO.png" />
</head>
   <!--font awesome con CDN para iconos-->  
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">  
      
<!-- -----------ARCHIVO CSS----------- -->
<link rel="stylesheet" href="css/style.css">
<!-- ---------FIN ARCHIVO CSS----------- -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- ------------DATATABLES----- -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script defer src="js/tabla.js"></script>
<!-- ------------FIN-DATATABLES----- -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');
</style>
<!-- ----------------------------- -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- ----------------------------- -->    
<div style="height:60px">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid ">
      <a href="inicio.view.php" class="navbar-brand mb-0 pr-3 ">
        <img class="d-line-block align-top " src="img/vida-silvestre.png" width="150px" style="margin-right:10px">
      </a>
      <!-- Toggle Btn-->
      <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler shadow-none border-0 bg-dark" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- SideBar -->
      <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ">
          <!-- ------------------------------------------------------- -->
          <li class="nav-item dropdown pr-3">
            <a class="nav-link dropdown-toggle active me-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Alumnos
            </a>
            <ul class="dropdown-menu">
              <!-- <li><a class="dropdown-item" href="inscripcion_alumno.php">Inscripcion Alumno</a></li> -->
              <li><a class="dropdown-item" href="seleccionar_alumnos.php">Inscripcion a Materia</a></li>
              <li><a class="dropdown-item" href="listadoalumnos.view.php">Listar Alumnos </a></li>
            </ul>
          </li>
          <!-- ------------------------------------------------------- -->
          <li class="nav-item active pr-3">
            <a class="nav-link" href="notas.view.php">Notas </a>
          </li>
          

          <li class="nav-item dropdown pr-3 ">
            <!-- Nueva parte de agregar notas  -->
            <a class="nav-link dropdown-toggle active me-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profesor
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="listadoprofe.php">Listado Profesor</a></li>
              <li><a class="dropdown-item" href="lista_A.php">Listado de Asignaciones</a></li>
              
            </ul>
          </li>
          <!-- ------------------------------------------------------- -->
          <li class="nav-item active pr-3">
            <a class="nav-link" href="listado_materia.php">Materias </a>
          </li>
          <!-- ------------------------------------------------------- -->
         
          <li class="nav-item dropdown pr-3 ">
            <!-- Nueva parte de agregar notas  -->
            <a class="nav-link dropdown-toggle active me-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Mesa y Acta
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="mesa_examen_add.php">Mesa de Examen</a></li>
              <li><a class="dropdown-item" href="listadomesa.php">Listado de Mesa de Examen</a></li>
              <li><a class="dropdown-item" href="acta_nota.php">Acta</a></li>
            </ul>
          </li>
          <!-- ------------------------------------------------------- -->
          <li class="nav-item active pr-3">
            <a class="nav-link" href="">Cliclo lectivo (crear) </span></a>
          </li>
          <!-- ------------------------------------------------------- -->
        </ul>
        <div class="ml-auto" id="salir">
          <a class="btn text-white text-decoration-none  py-1 px-3  mr-5 rounded-1 fw-semibold" role="button" href="logout.php">Salir</a>
        </div>
      </div>
    </div>
  </nav>
</div>