<?php

require "../vendor/autoload.php";

//require "../src/error_handler.php";

use eftec\bladeone\BladeOne;
use App\BD\BD;
use App\Modelo\Material;
use App\DAO\MaterialDao;

session_start();

$views = __DIR__ . '/../views';
$cache = __DIR__ . '/../cache';
$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);

$bd = BD::getConexion();

$materialDao = new MaterialDao($bd);
$dest  ; $mateAdded;

function validaNombre_FMaterial (String $foto):bool{
    $dir_fotosMaterial = "./asset/fotos_material";
    $nombresFMaterial = scandir($dir_fotosMaterial);
    foreach ($nombresFMaterial as $nomFoto){
        if($nomFoto == $foto)
            return false;
        
    }
    return true;
}
function guardaFMaterial (String $picture):bool{
    global $dest;
    $ruta = $_FILES['fMaterial']['tmp_name'];
    $dest = "./asset/fotos_material/".$picture;
    return move_uploaded_file($ruta, $dest);
}
function guardaNFMaterial (String $picture):bool{
    global $dest;
    $ruta = $_FILES['fNMaterial']['tmp_name'];
    $dest = "./asset/fotos_material/".$picture;
    return move_uploaded_file($ruta, $dest);
}

if(isset($_SESSION['usuario'])){
    $usuario =$_SESSION['usuario'];

  if (isset($_POST['add'])) {
        $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_UNSAFE_RAW));
        $errorDescrip = empty($descripcion);
        
        $fotoMaterial = trim($_FILES['fMaterial']['name']);
        $errorFMaterial = ($fotoMaterial !== "") ? (validaNombre_FMaterial($fotoMaterial) ? false : true) : false;

        $errRegistro = $errorDescrip || $errorFMaterial;
        if (!$errorFMaterial && !$errRegistro)
            guardaFMaterial($fotoMaterial);
        if ($errRegistro) {
            $descripcionGuardada = $descripcion;
            echo $blade->run("formMateriales", compact("errorDescrip", "errorFMaterial", "usuario", "descripcionGuardada"));
            die;
        } else {
            $propietario = $usuario->getId();
            $newMaterial = new Material((int)$propietario, $descripcion, $dest);
            $materialDao->creaMaterial($newMaterial);
            $mateAdded=true;
            $descripcion = '';
 //           header('Location:index.php?nuevoUsuario');
             echo $blade->run("formMateriales", compact('usuario','mateAdded'));
        }
    }
    elseif (isset ($_REQUEST['edicion'])) {
    $id = $_REQUEST['id'];
    $material = $materialDao->recuperaMaterialPorId((int)$id);
    if($material!== null){
        $_SESSION['material']=$material;
        echo $blade->run("editMaterial", compact('usuario','material'));
        die();
    }
    
    }
    elseif (isset ($_POST['update'])) {     //************EDICION***************************
        
        $fotoOld = trim(filter_input(INPUT_POST, 'fotoOld', FILTER_UNSAFE_RAW));
        
        $material = $_SESSION['material'];
        $idMat = $material->getId();
        $newFoto = trim($_FILES['fNMaterial']['name']);
        $errorNFMaterial = ($newFoto !== "") ? (validaNombre_FMaterial($newFoto) ? false : true) : false;
        $newDesc = trim(filter_input(INPUT_POST, 'descripcion', FILTER_UNSAFE_RAW));
        $errorNDesc = empty($newDesc);
        
        if($errorNDesc||$errorNFMaterial){
            echo $blade->run("editMaterial", compact('usuario','errorNDesc','errorNFMaterial','newDesc','material'));
            die();
        }
        else{
            //borra foto de material si la tiene
        $fotoOld !== "./asset/fotos_material/"? unlink($fotoOld):"";
        guardaNFMaterial($newFoto);
        $owner = $material->getPropietario();
        $newContenido = new Material((int)$owner,$newDesc,$dest);
        $materialDao->modificaMaterial($newContenido, (int)$idMat);
        header('Location:portada.php?actualizado');
        }
        
    }
    
    
    else {
        echo $blade->run("formMateriales", compact('usuario'));
    }
}else{
    echo $blade->run('login');
}