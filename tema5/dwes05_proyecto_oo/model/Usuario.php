<?php

class Usuario
{
    private $usuario;
    private $pass;

    public static function recuperaUsuarioPorCredencial(PDO $bd, string $nombreUsuario, string $pass): ?Usuario
    {
        $bd->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
        $passHashed = hash('sha256', $pass);
        $sql = 'select * from usuarios where usuario=:nombreUsuario and pass=:passHashed';
        $sth = $bd->prepare($sql);
        $sth->execute([":nombreUsuario" => $nombreUsuario, ":passHashed" => $passHashed]);
        $sth->setFetchMode(PDO::FETCH_CLASS, Usuario::class);
        $usuario = ($sth->fetch()) ?: null;
        return $usuario;
    }

    public function __construct(string $usuario = null, string $pass = null)
    {
        if (!is_null($usuario)) {
            $this->usuario = $usuario;
        }
        if (!is_null($pass)) {
            $this->pass = $pass;
        }
    }

    

    public function getUsuario(): string
    {
        return $this->usuario;
    }

    public function setUsuario(string $usuario)
    {
        $this->usuario = $usuario;
    }

    public function getPass(): string
    {
        return $this->pass;
    }

    public function setPass(string $pass)
    {
        $this->pass = $pass;
    }

}
