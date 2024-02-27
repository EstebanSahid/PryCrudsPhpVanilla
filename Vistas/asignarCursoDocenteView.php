<?php
include '../Conexion/conexion.php';

$indexTabla = [];
$filtro = (isset($_POST['txt_tipoAsignacion'])) ? $_POST['txt_tipoAsignacion'] : "";

if(isset($filtro)){
    if($filtro == 1){
        //Curso
        $index = $pdo->prepare("SELECT 
                                    cu_nombre as nombre,
                                    cu_fechaCreacion as fecha_creacion,
                                    cu_id as id 
                                FROM cursos WHERE cu_estado = 1 AND emp_id = 1");
        $index -> execute();
        $indexTabla = $index->fetchAll(PDO::FETCH_ASSOC);

    }elseif($filtro == 2){
        //Docente
        $index = $pdo->prepare("SELECT 
                                    CONCAT(doc_primerApellido,' ', doc_primerNombre, ' ', doc_segundoNombre) as nombre,
                                    doc_fechaCreacion as fecha_creacion,
                                    doc_id as id
                                FROM docente WHERE doc_estado = 1");
        $index -> execute();
        $indexTabla = $index->fetchAll(PDO::FETCH_ASSOC);
        
    }else{
        //echo "Error";
    }
}

if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("La inserción fue exitosa.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante la inserción.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

/*if(isset($_GET['editado'])) {
    if ($_GET['editado'] == "true") {
        echo '  <script>
                    alert("Modificado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante la Modificación del Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

if(isset($_GET['eliminado'])) {
    if ($_GET['eliminado'] == "true") {
        echo '  <script>
                    alert("Eliminado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante al Eliminar  el Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}*/
//print_r($indexTabla);
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
        <div class="hero_area">
            <!-- Menu -->
            <?php include 'header.html'; ?>
            <!-- Menu -->
        </div>

        <!-- Select Asignar -->
        <div class="container p-4">
            <form action="" method="post">
                <div class="row">
                    <div class="custom_heading-container">
                        <h3>
                            Asignar Cursos a Docentes
                        </h3>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-3">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" name="txt_tipoAsignacion" aria-label="Floating label select example" required>
                                <option value="0">-- Seleccione un Filtro --</option>
                                <option value="1">Curso</option>
                                <option value="2">Docente</option>
                            </select>
                            <label for="floatingSelect">Asignar Por</label>
                        </div>
                    </div>
                    <div class="col-3 my-auto">
                        <button value="btnFiltrar" type="submit" name="accion" class="btn btn-primary">Filtrar</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Select Asignar -->

        <div class="divider border-bottom"></div>

        <div class="pt-3">
            <?php if($filtro == 1): ?>
                <h3 class="text-center">Cursos</h3>
            <?php elseif($filtro == 2): ?>
                <h3 class="text-center">Docentes</h3>
            <?php endif; ?>
        </div>

        <!-- Tabla -->
        <div class="container ">
            <div class="row pt-2">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <?php if($filtro == 1): ?>
                                <th class="text-center">Curso</th>
                                
                            <?php elseif($filtro == 2): ?>
                                <th class="text-center">Docente</th>
                                
                            <?php endif; ?>
                            <th class="text-center">Fecha de Creacion</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <?php foreach($indexTabla as $ind){ ?>
                        <tr>
                            <td class="text-center"><?= $ind['nombre']; ?></td>
                            <td class="text-center"><?= $ind['fecha_creacion']; ?></td>
                            <td> 
                                <div class="d-flex justify-content-center align-middle contact_crud">
                                <?php if($filtro == 1): ?>
                                    <button class="verDocentes btn btn-primary mr-2"
                                        data-id="<?= $ind['id'] ?>"
                                        data-nombre="<?= $ind['nombre']; ?>">
                                        Visualizar
                                    </button>
                                    <button class="asignarDocentes btn btn-primary mr-2"
                                        data-id="<?= $ind['id'] ?>"
                                        data-nombre="<?= $ind['nombre']; ?>">
                                        Asignar Docente
                                    </button>
                                <?php elseif($filtro == 2): ?>
                                    <button class="verCursos btn btn-primary mr-2"
                                        data-id="<?= $ind['id'] ?>"
                                        data-nombre="<?= $ind['nombre']; ?>">
                                        Visualizar
                                    </button>
                                    <button class="asignarCursos btn btn-primary mr-2"
                                        data-id="<?= $ind['id'] ?>"
                                        data-nombre="<?= $ind['nombre']; ?>">
                                        Asignar Curso
                                    </button>
                                <?php endif; ?>
                                </div>
                            </td>
                            
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- Tabla -->

        <!-- footer section -->
        <section class="container-fluid footer_section">
            <p>
                Copyright &copy; 2019 All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
            </p>
        </section>
        <!-- footer section -->

        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>

        <!-- Modales -->

        <!-- Modal Agregar Docentes -->
        <div class="modal" tabindex="-1" id="modalAddDocente">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Docente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/asignarCursoDocenteController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_id" id="txt_id">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_docente" placeholder="" name="txt_docente" readonly>
                                        <label for="txt_docente">Curso</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <section id="addDocente"></section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregarCurso" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Agregar Cursos  --> 
        <div class="modal" tabindex="-1" id="modalAddCurso">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/asignarCursoDocenteController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_id" id="txt_id">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_Curso" placeholder="" name="txt_Curso" readonly>
                                        <label for="txt_Curso">Docente</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <section id="addCurso"></section>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregarDocente" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Docentes -->
        <div class="modal " tabindex="-1" id="modalViewDocentes">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Docentes Asignados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3 id="txt_curso"></h3>
                        <section class="pt-2" id="showModalViewDocentes"></section>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Ver Cursos -->
        <div class="modal " tabindex="-1" id="modalViewCursos">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cursos Asignados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3 id="txt_docente"></h3>
                        <section class="pt-2" id="showModalViewCursos"></section>
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

                //Cursos
                $('.asignarCursos').click(function(){ addCurso
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    addCursos(id, nombre);
                });

                $('.verCursos').click(function(){
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    mostrarCursos(id, nombre);
                });

                //Docentes
                $('.asignarDocentes').click(function(){
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    console.log(id)
                    addDocentes(id, nombre);
                });

                $('.verDocentes').click(function(){
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    mostrarDocentes(id, nombre);
                });

                function addDocentes(id, nombre) {
                    $.ajax({
                        data: {
                            id: id,
                        },
                        url: "../Controladores/asignarCursoDocenteController.php?exec=addDocente",
                        type: "POST",
                        success: function (r) {
                            $('#modalAddDocente #txt_docente').val(nombre);
                            $('#modalAddDocente #txt_id').val(id);
                            $('#modalAddDocente').modal('show');

                            $("#addDocente").html(r);
                        },
                    });
                }

                function addCursos(id, nombre) {
                    $.ajax({
                        data: {
                            id: id,
                        },
                        url: "../Controladores/asignarCursoDocenteController.php?exec=addCursos",
                        type: "POST",
                        success: function (r) {
                            $('#modalAddCurso #txt_Curso').val(nombre);
                            $('#modalAddCurso #txt_id').val(id);
                            $('#modalAddCurso').modal('show');

                            $("#addCurso").html(r);
                        },
                    });
                }

                function mostrarDocentes(id_curso, nombre) {
                    $.ajax({
                        data: {
                            id_curso: id_curso,
                        },
                        url: "../Controladores/asignarCursoDocenteController.php?exec=mostrarDocente",
                        type: "POST",
                        success: function (r) {
                            $('#modalViewDocentes #txt_curso').text(nombre);
                            $('#modalViewDocentes').modal('show');
                            $("#showModalViewDocentes").html(r);
                        },
                    });
                }

                function mostrarCursos(id_doc, nombre) {
                    $.ajax({
                        data: {
                            id_doc: id_doc,
                        },
                        url: "../Controladores/asignarCursoDocenteController.php?exec=mostrarCurso",
                        type: "POST",
                        success: function (r) {
                            $('#modalViewCursos #txt_docente').text(nombre);
                            $('#modalViewCursos').modal('show');
                            $("#showModalViewCursos").html(r);
                        },
                    });
                }
            });
        </script>
        <!-- Scripts -->
    </body>
</html>