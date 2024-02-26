<?php
include '../Conexion/conexion.php';


if (isset($_GET["exec"]) and $_GET["exec"] == "mostrarDocente") {
    $sql = $pdo->prepare("SELECT 
	                        cxd.cxd_fechaCreacion,
	                        CONCAT(d.doc_primerApellido,' ', d.doc_segundoApellido, ' ', d.doc_primerNombre) as docente FROM cursoxdocente cxd
                        INNER JOIN docente d ON d.doc_id = cxd.doc_id
                        WHERE cxd.cu_id = :val1");
    $sql->bindParam(':val1', $_POST['id_curso']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php foreach($listado as $lista){ ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><?= $lista["docente"] ?></div>
                    <?= $lista["cxd_fechaCreacion"] ?>
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "mostrarCurso") {
    $sql = $pdo->prepare("SELECT
                            cxd.cxd_fechaCreacion,
                            c.cu_nombre
                        FROM cursoxdocente cxd
                        INNER JOIN cursos c ON c.cu_id = cxd.cu_id
                        WHERE cxd.doc_id = :val1");
    $sql->bindParam(':val1', $_POST['id_doc']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php 
        if(!empty($listado)){
            foreach($listado as $lista){ ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?= $lista["cu_nombre"] ?></div>
                        <?= $lista["cxd_fechaCreacion"] ?>
                    </div>
                </li>
            <?php } 
        }else{ ?>
            <li class="d-flex justify-content-between align-items-start text-center">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Sin Registros</div>
                    Por favor Asignar un Curso al Docente
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}