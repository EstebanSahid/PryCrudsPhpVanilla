<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT * FROM cursos WHERE emp_id = 1 AND cu_estado = 1");
$index -> execute();
$listaCursos = $index->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("La inserción fue exitosa.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    } elseif($_GET['guardado'] == "existe"){
        echo '  <script>
                    alert("No insertado, el Curso ya existe");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }else {
        echo '  <script>
                    alert("Hubo un error durante la inserción.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }
}

if(isset($_GET['editado'])) {
    if ($_GET['editado'] == "true") {
        echo '  <script>
                    alert("Modificado Exitosamente.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    } elseif($_GET['editado'] == "existe"){
        echo '  <script>
                    alert("No Modificado, el Curso ya existe");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }else {
        echo '  <script>
                    alert("Hubo un error durante la Modificación del Registro.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }
}

if(isset($_GET['eliminado'])) {
    if ($_GET['eliminado'] == "true") {
        echo '  <script>
                    alert("Eliminado Exitosamente.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante al Eliminar  el Registro.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }
}
//print_r($listaCursos);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>ACME</title>

        <!-- slider stylesheet -->
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="../css/responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
    </head>

    <body>
        <!-- Menu -->
        <div class="hero_area">
            <?php include 'header.html'; ?>
        </div>
        
        <div class="container pt-4">
            <!-- Boton -->
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    <div class="d-flex justify-content-end service_container">
                        <div class="d-flex justify-content-center contact_section">
                            <button id="agregarCursoBtn">
                                Agregar Curso
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabla -->
            <div class="row pt-4">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Curso</th>
                            <th class="text-center align-middle">Fecha de Creación</th>
                            <th class="text-center align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <?php $idti_hidden = 0;
                    foreach($listaCursos as $Curso){?>
                        <tr>
                            <td class="text-center align-middle"><?= $Curso['cu_nombre']; ?></td>
                            <td class="text-center align-middle"><?= $Curso['cu_fechaCreacion']; ?></td>
                            <td class="align-middle"> 
                                <div class="d-flex justify-content-center contact_crud">
                                    <button class="editarCursoBtn btn btn-primary mr-2"
                                            data-id="<?= $Curso['cu_id'];?>"
                                            data-nombre="<?= $Curso['cu_nombre']; ?>"
                                            >
                                        Editar
                                    </button>
                                    <button class="eliminarEmpresaBtn btn btn-primary mr-2"
                                            data-id="<?= $Curso['cu_id'];?>">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                            
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        
        <!-- footer section -->
        <section class="container-fluid footer_section">
            <p>
                Copyright &copy; 2019 All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
            </p>
        </section>

        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Modales -->

        <!-- Modal Agregar -->
        <div class="modal" tabindex="-1" id="modalAdd">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/CursoController.php" method="post">
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="txt_id">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_curso" placeholder="" name="txt_curso" required>
                                        <label for="txt_curso">Curso</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal" tabindex="-1" id="modalEdit">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="../Controladores/CursoController.php" method="post">
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="txt_id" id="txt_id">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_curso" placeholder="" name="txt_curso" required>
                                        <label for="txt_curso">Curso</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnModificar" type="submit" name="accion" class="btn btn-primary">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal " tabindex="-1" id="modalDelete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/CursoController.php" method="post">
                            <input type="hidden" name="txt_id" id="txt_id">
                            <p>¿Está Seguro de Eliminar el Registro?</p>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnEliminar" type="submit" name="accion" class="btn btn-primary">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modales -->

        <!-- Scripts -->
        <script>
            $(document).ready(function() {

                // Inicializar DataTable
                $('#example').DataTable();

                //Abrir el Modal para Agregar
                $('#agregarCursoBtn').click(function(){
                    $('#modalAdd').modal('show');
                });

                //Abrir el Modal Para Editar
                $('.editarCursoBtn').click(function(){

                    console.log("clic editar")
                    // Obtener los datos del botón
                    var idCurso = $(this).data('id');
                    var nombre = $(this).data('nombre');

                    // Asignar los datos al formulario del modal
                    $('#modalEdit #txt_id').val(idCurso);
                    $('#modalEdit #txt_curso').val(nombre);

                    //Activar el Modal
                    $('#modalEdit').modal('show');
                });

                //Abrir el Modal Para Eliminar
                $('.eliminarEmpresaBtn').click(function(){
                    var idCurso = $(this).data('id');
                    console.log(idCurso);
                    $('#modalDelete #txt_id').val(idCurso);
                    $('#modalDelete').modal('show');
                });

                $('.asignarCursoBtn').click(function(){
                    var idCurso = $(this).data('id');
                    $('#modalDelete #txt_id').val(idCurso);
                    $('#modalDelete').modal('show');
                });
            });
        </script>
        <!-- Scripts -->
    </body>
</html>