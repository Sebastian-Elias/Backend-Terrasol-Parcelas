<?php

class Controlador
{
    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll()
    {
        $con = new Conexion();
        $sql = "SELECT
                pc.id,
                pc.tipo,
                pc.lote,
                pc.ubicacion,
                pc.tamaño_terreno,
                pc.descripcion_casa,
                pc.precio,
                pc.propietario,
                s.electricidad,
                s.agua_potable,
                s.alcantarillado,
                s.internet,
                pc.activo
            FROM
                parcelas_con_casas AS pc;";
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs) {
            while ($tupla = mysqli_fetch_assoc($rs)) {
                $tupla['activo'] = $tupla['activo'] == 1 ? true : false;
                array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

    public function postNuevo($_nuevoObjeto)
    {
        $con = new Conexion();
        //var_dump($_nuevoObjeto->nombre);
        $id = count($this->getAll()) + 1;
        $sql = "INSERT INTO parcelas_con_casas (id, tipo, lote, ubicacion, tamaño_terreno, descripcion_casa, electricidad, agua_potable, alcantarillado, internet, precio, propietario, activo) VALUES ($id, '$_nuevoObjeto->tipo', '$_nuevoObjeto->lote', '$_nuevoObjeto->ubicacion', '$_nuevoObjeto->tamaño_terreno', '$_nuevoObjeto->descripcion_casa', '$_nuevoObjeto->electricidad', '$_nuevoObjeto->agua_potable', '$_nuevoObjeto->alcantarillado', '$_nuevoObjeto->internet', '$_nuevoObjeto->precio', '$_nuevoObjeto->propietario', true)";
        // echo $sql;
        //ejecutar sql
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        //cerar conexion
        $con->closeConnection();
        //rs -> resultado de la ejecucion de la query
        if ($rs) {
            return true;
        }
        return null;
    }

    public function patchEncenderApagar($_id, $_accion)
    {
        $con = new Conexion();
        $sql = "UPDATE parcelas_con_casas SET activo = $_accion WHERE id = $_id;";
        // echo $sql;
        //ejecutar sql
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        //cerar conexion
        $con->closeConnection();
        //rs -> resultado de la ejecucion de la query
        if ($rs) {
            return true;
        }
        return null;
    }

    public function putNombreById($_nombre, $_id)
    {
        $con = new Conexion();
        $sql = "UPDATE parcelas_con_casas SET nombre = '$_nombre' WHERE id = $_id;";
        // echo $sql;
        //ejecutar sql
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        //cerar conexion
        $con->closeConnection();
        //rs -> resultado de la ejecucion de la query
        if ($rs) {
            return true;
        }
        return null;
    }

    public function deleteById($_id)
    {
        $con = new Conexion();
        $sql = "DELETE FROM parcelas_con_casas WHERE id = $_id;";
        //echo $sql;
        //ejecutar sql
        $rs = [];
        try {
            $rs = mysqli_query($con->getConnection(), $sql);
        } catch (\Throwable $th) {
            $rs = null;
        }
        // var_dump($rs);
        //cerar conexion
        $con->closeConnection();
        //rs -> resultado de la ejecucion de la query
        if ($rs) {
            return true;
        }
        return null;
    }
}
