<?php require 'navbar.php'; ?>


<section class="content mt-2">
    <div class="row m-auto ">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">*Nombre y Apellido del alumno*</h5>
                    <a class="btn btn-primary float-right mb-2" href="">Información</a>                    
                </div>
                <div class="card-body table-responsive">
                    <table id="" class="table table-bordered table-sm" >
                        <thead class="thead-dark">
                            <th>#</th>
                            <th>Materia</th>
                            <th>Inscribir</th>
                            <th>Nota 1</th>
                            <th>Nota 1</th>
                            <th>Nota 1</th>
                            <th>Nota 1</th>
                            <th>Nota F</th>
                            <th>Estado</th>              
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>lengua</td>
                                <td>
                                    <style>
                                        #text{
                                            display: none;
                                        }
                                    </style>   
                                    <button id="boton" onclick="mostrar();" class="btn btn-danger btn-sm btn-block" href="">Inscribir</button>                                 
                                    <!-- <a class="btn btn-danger btn-sm btn-block" href="">Inscribir</a> -->
                                    <div id="text" class="bg-success text-white text-center" >
                                        Inscripto
                                    </div>
                                    <script>
                                        function mostrar(){
                                            document.getElementById('text').style.display='block';
                                            document.getElementById('boton').style.display='none';
                                        }                                     
                                    </script>
                                </td>
                                <td>nota1</td>
                                <td>nota1</td>
                                <td>nota1</td>
                                <td>nota1</td>
                                <td>notaf</td>
                                <td>libre</td>
                                <!-- libre ,regular,aprobado -->
                            </tr>
                        </tbody>
                    </table>

                </div>    
            </div> 
        </div>   
    </div>
</section>



<?php require 'footer.php'; ?>