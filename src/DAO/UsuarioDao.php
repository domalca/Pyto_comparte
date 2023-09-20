<?php
namespace App\DAO;


use PDO;
use App\Modelo\Usuario;

class UsuarioDao {

    private $bd;

    function __construct($bd) {
        $this->bd = $bd;
    }

    function creaUsuario(object $usuario): bool {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $passHassed = hash('sha256', $usuario->getPassword());
        $sql = "insert into usuarios (nombre,password,email,foto_perfil) values(:nombre,:password,:email,:foto)";
        $stm = $this->bd->prepare($sql);
        try {
            $resul = $stm->execute([
               ':nombre'=>$usuario->getNombre(),
                ':password'=>$passHassed,
                ':email'=>$usuario->getEmail(),
                ':foto'=>$usuario->getFoto_perfil()
            ]);
            return true;
        } catch (PDOException $ex) {
            return false;
            
            die('error al insertar usuario: '.$ex->getMessage());
        }
        
    }

    function modifica($usuario) {
        
    }

    function elimina($nombre) {
        
    }

    /* function recuperaPorCredencial($nombre, $pwd) {
      $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
      $pwdHashed = hash('sha256', $pwd);
      $sql = 'select * from usuarios where usuario=:nombre and pass=:pwdHashed';
      $sth = $this->bd->prepare($sql);
      $sth->execute([":nombre" => $nombre, ":pwdHashed" => $pwdHashed]);
      $sth->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Usuario::class);
      $usuario = ($sth->fetch()) ?: null;
      return $usuario;
      } */

    function recuperaPorCredencial($nombre, $pwd) {
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $pwdHashed = hash('sha256', $pwd);
        $sql = 'select * from usuarios where nombre=:nombre and password=:pwdHashed';
//        $sql = 'select * from usuarios where nombre=:nombre and password=:pwd';
        $sth = $this->bd->prepare($sql);
        $sth->execute([":nombre" => $nombre, ":pwdHashed" => $pwdHashed]);
//        $sth->execute([":nombre" => $nombre, ":pwdHashed" => $pwd]);
//        $sth->execute([":nombre" => $nombre, ":pwd" => $pwd]);
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        return $usuario;
    }
    function existe_nombreUsuario(String $nombre):bool{
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = 'select nombre from usuarios';
        $sth = $this->bd->prepare($sql);
        $sth->execute();
        $nombresUsu = $sth->fetchAll();
        foreach($nombresUsu as $nomUsu){
            if($nomUsu[0] == $nombre)
            {return true;}
        }
        return false;
    }
    function recuperaRestoUsuarios ($propioUsuario):Array{
        $restoUsu = [];
        $this->bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $sql = 'select nombre,foto_perfil from usuarios';
        $sth = $this->bd->prepare($sql);
        try {
            $sth->execute();
            $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
            $nombresUsu = $sth->fetchAll();
        } catch (PDOException $ex) {
            die("error al recuperar resto de usuarios ".$ex->getMessage());
        }
 //       $cont =0;
        foreach ($nombresUsu as $usu){
            $nombre = $usu->getNombre();
            if ($propioUsuario !== $nombre)
                $restoUsu[]=$usu;
        }
        return $restoUsu;
    }

}
