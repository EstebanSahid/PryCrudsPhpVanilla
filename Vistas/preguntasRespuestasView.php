<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT p.*, c.* FROM preguntas p INNER JOIN cursos c ON p.cu_id = c.cu_id");
$index -> execute();
$listaPreguntas = $index->fetchAll(PDO::FETCH_ASSOC);

$cursos = $pdo->prepare("SELECT * FROM cursos");
$cursos -> execute();
$listacursos = $cursos->fetchAll(PDO::FETCH_ASSOC);

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
//print_r($listaPreguntas);
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
        <style>
            #chips{
                margin-bottom: 10px;
            }

            .eliminarBoton{
                cursor: pointer;
                color: red;
                margin-left: 5px;
            }
        </style>
    </head>

    <body>
        <!-- Menu -->
        <div class="hero_area">
            <?php include 'header.html'; ?>
        </div>

        <div class="container pt-4">
            <div class="custom_heading-container">
                <h3>
                    Banco de Preguntas
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
                            <button id="agregarCursoBtn">
                                Agregar Pregunta
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
                            <th class="text-center align-middle">Enunciado</th>
                            <th class="text-center align-middle">Curso</th>
                            <th class="text-center align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <?php $idti_hidden = 0;
                    foreach($listaPreguntas as $pregunta){?>
                        <tr>
                            <td class="text-center align-middle"><?= $pregunta['pre_enunciado']; ?></td>
                            <td class="text-center align-middle"><?= $pregunta['cu_nombre']; ?></td>
                            <td class="align-middle"> 
                                <div class="d-flex justify-content-center contact_crud">
                                    <button class="verRespuestasBtn btn btn-primary mr-2"
                                            data-id="<?= $pregunta['pre_id'];?>"
                                            data-nombre="<?= $pregunta['pre_enunciado'];?>"
                                            >
                                        Ver Respuestas
                                    </button>
                                    <button class="eliminarPreguntaBtn btn btn-primary mr-2"
                                            data-id="<?= $pregunta['pre_id'];?>">
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
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Pregunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/preguntaRespuestaController.php" method="post">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" name="txt_idcurso" aria-label="Floating label select example" required>
                                            <?php foreach($listacursos as $curso){ ?>
                                            <option value="<?= $curso["cu_id"]; ?>">
                                                <?= $curso["cu_nombre"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <label for="floatingSelect">Tipo de Identificación</label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_pregunta" placeholder="" id="txt_pregunta" required>
                                        <label for="txt_pregunta">Pregunta</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="inputPregunta" placeholder="" id="inputPregunta">
                                        <label for="inputPregunta">Respuestas</label>
                                    </div>
                                </div>
                                <!--
                                <div class="col-2">
                                    <label for="">¿Es correcto?</label>
                                    <input type="checkbox" id="checkPregunta">
                                </div>-->
                                <div class="col-1" style="margin-top: 12px;">
                                    <a href="#" class="btn btn-success btn-xs" onclick="addPregunta()">
                                        +
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <input type="hidden" name="preguntas_array" id="preguntas_array" value="">
                                    <ul id="listaPreguntas" name="chip" id="chip" class="list-group"></ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_esCorrecto" placeholder="" id="txt_esCorrecto" required>
                                        <label for="txt_esCorrecto">N° Respuesta Correcta</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-4">
                                <div class="">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary" onclick="prepararEnvio()">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal View -->
        <div class="modal" tabindex="-1" id="modalView">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Respuestas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <label class="fw-bold" id="txt_pregunta"></label>
                        </div>
                        <section id="respuestas_view"></section>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal " tabindex="-1" id="modalDelete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Pregunta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/preguntaRespuestaController.php" method="post">
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
                $('.verRespuestasBtn').click(function(){
                    console.log("clic editar");
                    var id_pregunta = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    verRespuestas(id_pregunta, nombre);
                });

                function verRespuestas(id_pregunta, nombre){
                    $.ajax({
                        data: {
                            id_pregunta: id_pregunta,
                        },
                        url: "../Controladores/preguntaRespuestaController.php?exec=respuestasView",
                        type: "POST",
                        success: function (r) {
                            $('#modalView #txt_pregunta').text(nombre);
                            $('#modalView').modal('show');
                            $("#respuestas_view").html(r);
                        },
                    });
                }

                //Abrir el Modal Para Eliminar
                $('.eliminarPreguntaBtn').click(function(){
                    var id_pregunta = $(this).data('id');
                    console.log(id_pregunta);
                    $('#modalDelete #txt_id').val(id_pregunta);
                    $('#modalDelete').modal('show');
                });
            });

            const preguntas = [];
            const valorRespuesta = [];

            function addPregunta() {
                console.log("clid add");
                const inputPregunta = document.getElementById('inputPregunta').value;

                console.log(inputPregunta);

                if (inputPregunta !== '') {
                    preguntas.push(inputPregunta);
                    actualizarLista();
                    document.getElementById('inputPregunta').value = ''; // Limpiar el input al agregar
                }
            }

            function actualizarLista(){
                const listaPreguntas = document.getElementById('listaPreguntas');
                listaPreguntas.innerHTML = '';

                var i = 0;

                preguntas.forEach((pregunta, index) => {
                    
                    const li = document.createElement('li');
                    li.textContent = pregunta;

                    const btnEliminar = document.createElement('span');
                    btnEliminar.textContent = 'x';
                    btnEliminar.classList.add('eliminarBoton');
                    btnEliminar.onclick = () => deletePregunta(index);

                    
                    li.appendChild(btnEliminar);
                    li.classList.add('list-group-item');
                    listaPreguntas.appendChild(li);
                })
            }

            function deletePregunta(id){
                preguntas.splice(id,1);
                actualizarLista();
            }

            function prepararEnvio() {
                var listaElementos = document.getElementById('listaPreguntas');
                var elementos = listaElementos.getElementsByTagName('li');
                var preguntasArray = [];

                for (var i = 0; i < elementos.length; i++) {
                    preguntasArray.push(elementos[i].textContent.trim());
                }

                document.getElementById('preguntas_array').value = JSON.stringify(preguntasArray);
            }
        </script>
        <!-- Scripts -->
    </body>
</html>