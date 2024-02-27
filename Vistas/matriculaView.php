<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT 
                            CONCAT(e.est_primerApellido, ' ',e.est_segundoApellido, ' ', e.est_primerNombre) as estudiante,
                            m.mat_fechaCreacion as fechaMatricula,
                            c.cu_id,
                            c.cu_nombre,
                            CONCAT(d.doc_primerApellido, ' ',d.doc_segundoApellido, ' ', d.doc_primerNombre) as docente
                            FROM matricula m
                            INNER JOIN estudiante e ON e.est_id = m.est_id
                            INNER JOIN cursoxdocente cxd ON cxd.cxd_id = m.cxd_id
                            INNER JOIN cursos c ON c.cu_id = cxd.cu_id
                            INNER JOIN docente d ON cxd.doc_id = d.doc_id
                            ORDER BY cu_nombre");
$index -> execute();
$listaMatriculados = $index->fetchAll(PDO::FETCH_ASSOC);

$selectEstudiante = $pdo->prepare("SELECT e.*, CONCAT(e.est_primerApellido, ' ',e.est_segundoApellido, ' ', e.est_primerNombre) as estudiante FROM estudiante e WHERE e.est_estado = 1");
$selectEstudiante -> execute();
$listaEstudiante = $selectEstudiante->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("Matriculado Correctamente.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    } elseif($_GET['guardado'] == "incompleto"){
        echo '  <script>
                    alert("Todos los Campos deben ser asignados para la matricula");
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

/*if(isset($_GET['editado'])) {
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
}*/
//print_r($listaMatriculados);
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
            <div class="custom_heading-container">
                <h3>
                    Matricula
                </h3>
            </div>
        </div>
        
        <div class="container">
            <!-- Boton -->
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    <div class="d-flex justify-content-end service_container">
                        <div class="d-flex justify-content-center contact_section">
                            <button id="agregarMatricula">
                                Matricular
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
                            <th class="text-center align-middle">Alumno</th>
                            <th class="text-center align-middle">Curso</th>
                            <th class="text-center align-middle">Docente</th>
                            <th class="text-center align-middle">Fecha de Matricula</th>
                        </tr>
                    </thead>
                    <?php $idti_hidden = 0;
                    foreach($listaMatriculados as $matricula){?>
                        <tr>
                            <td class="text-center align-middle"><?= $matricula['estudiante']; ?></td>
                            <td class="text-center align-middle"><?= $matricula['cu_nombre']; ?></td>
                            <td class="text-center align-middle"><?= $matricula['docente']; ?></td>
                            <td class="text-center align-middle"><?= $matricula['fechaMatricula']; ?></td>
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Matricular Alumno</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/matriculaController.php" method="post">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="id_alumno" name="txt_id_alumno" aria-label="Floating label select example" required>
                                            <option value="0">
                                                - Seleccionar Estudiante -
                                            </option>
                                            <?php foreach($listaEstudiante as $estudiante){ ?>
                                            <option value="<?= $estudiante["est_id"]; ?>">
                                                <?= $estudiante["estudiante"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <label for="id_alumno">Estudiante</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <section id="selectCurso"></section>
                                </div>
                                <div class="col-4">
                                    <section id="selectDocente"></section>
                                </div>
                            </div>
                            <div class="row pt-4">
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
        <!-- Modales -->

        <!-- Scripts -->
        <script>
            $(document).ready(function() {

                // Inicializar DataTable
                $('#example').DataTable();

                //Abrir el Modal para Agregar
                $('#agregarMatricula').click(function(){
                    $('#modalAdd').modal('show');
                });

                // Select Dinámico para Curso
                $('#id_alumno').on('change', function(){
                    var id_alumno = $(this).val();
                    console.log("seleccionado ", id_alumno);
                    selectCurso(id_alumno);
                })

                function selectCurso(id_alumno) {
                    $.ajax({
                        data: {
                            id_alumno: id_alumno,
                        },
                        url: "../Controladores/matriculaController.php?exec=selectCurso",
                        type: "POST",
                        success: function (r) {
                            $("#selectCurso").html(r);
                        },
                    });
                }

                // Select Dinámico para Docentes
                $('#selectCurso').on('change', function(){
                    var id_curso = $('#id_curso').val();
                    console.log("Custo ", id_curso);
                    selectDocente(id_curso);
                })

                function selectDocente(id_curso) {
                    $.ajax({
                        data: {
                            id_curso: id_curso,
                        },
                        url: "../Controladores/matriculaController.php?exec=selectDocente",
                        type: "POST",
                        success: function (r) {
                            $("#selectDocente").html(r);
                        },
                    });
                }
            });
        </script>
        <!-- Scripts -->
    </body>
</html>