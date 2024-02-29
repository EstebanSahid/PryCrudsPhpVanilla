<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT p.*, c.cu_nombre FROM planificacion p
                        INNER JOIN cursos c ON c.cu_id = p.cu_id
                        WHERE p.plan_estado = 1");
$index -> execute();
$ListaPlanificacion = $index->fetchAll(PDO::FETCH_ASSOC);

$cursos = $pdo->prepare("SELECT * FROM cursos WHERE cu_estado = 1");
$cursos -> execute();
$listacursos = $cursos->fetchAll(PDO::FETCH_ASSOC);


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

if(isset($_GET['editado'])) {
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
}
//print_r($ListaPlanificacion);
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

        <div class="container pt-4">
            <div class="custom_heading-container">
                <h3>
                    Planificar
                </h3>
            </div>
        </div>
        
        <!-- Tabla -->
        <div class="container pt-4">
            <div class="row">
                <div class="col-4">
                    <div class="col-4 d-flex justify-content-start service_container">
                        <div class="d-flex justify-content-center contact_section">
                            <!-- Default dropend button -->
                            <div class="btn-group dropend">
                                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Administrar
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="./asignarCursoDocenteView.php">Asignar Curso a Docente</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="./matriculaView.php">Matricula Alumno</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    

                </div>
                <div class="col-4 d-flex justify-content-end service_container">
                    <div class="d-flex justify-content-center contact_section">
                        <button id="agregarplanifBtn">
                            Agregar Planificacion
                        </button>
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Tema</th>
                            <th class="text-center">Lugar</th>
                            <th class="text-center">Comentarios</th>
                        </tr>
                    </thead>
                    <?php foreach($ListaPlanificacion as $planif){ ?>
                        <tr>
                            <td class="text-center"><?= $planif['cu_nombre']; ?></td>
                            <td class="text-center"><?= $planif['plan_tema']; ?></td>
                            <td class="text-center"><?= $planif['plan_lugar']; ?></td>
                            <td class="text-center"><?= (($planif['plan_comentarios'] == "") ? "-" : $planif['plan_comentarios'])  ?> </td>
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

        <!-- Modal Agregar -->
        <div class="modal" tabindex="-1" id="modalAdd">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nueva Planificacion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/planifController.php" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" name="id_curso" aria-label="Floating label select example">
                                            <?php foreach($listacursos as $curso){ ?>
                                                <option value="<?= $curso["cu_id"]; ?>" selected>
                                                    <?= $curso["cu_nombre"]; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <label for="floatingSelect">Curso</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_nombre" placeholder="" name="txt_nombre" required>
                                        <label for="txt_nombre">Tema</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_lugar" placeholder="" id="txt_lugar" required>
                                        <label for="txt_lugar">Sede</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <input type="checkbox" id="check_esExamen" name="check_esExamen" value="valor1">
                                    <label for="check_esExamen">¿Es Exámen?</label>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_numPreguntas" placeholder="" id="txt_numPreguntas" readonly>
                                        <label for="txt_numPreguntas">N° Preguntas</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-floating">
                                    <textarea class="form-control" name="txt_area_comentarios" placeholder="" id="floatingTextarea" cols="30" rows="10"></textarea>
                                    <label for="floatingTextarea" class="ml-2">Comentarios:</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            
                            <!--
                            <button value="btnModificar" type="submit" name="accion">Modificar</button>
                            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                            <button value="btnCancelar" type="submit" name="accion">Cancelar</button>
                            -->
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
                $('#agregarplanifBtn').click(function(){
                    console.log("click aqui")
                    $('#modalAdd').modal('show');
                });

                var checkbox = document.getElementById("check_esExamen");
                var inputPreguntas = document.getElementById("txt_numPreguntas");

                checkbox.addEventListener('change', function() {
                    if (checkbox.checked) {
                        inputPreguntas.removeAttribute("readonly");
                    } else {
                        inputPreguntas.setAttribute("readonly", "readonly");
                    }
                });
            });
        </script>
        <!-- Scripts -->
    </body>
</html>