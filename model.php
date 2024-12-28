<?php

class FilmAPI
{
    private function server()
    {
        try {
            $db = new PDO("mysql:host=localhost;dbname=film_api", "root", "");
            // set the PDO error mode to exception
            $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            return $db;
            //echo "<h4>Connexion établie</h4>";
        } catch (\Exception $e) {
            die("<h4>Échec de connection: </h4>" . $e->getMessage());
        }
    }

    //DEBUT CRUD
    public function read($table, $fields)
    {//READ
        $db = $this->server();
        $req = $db->query('SELECT ' . $fields . ' FROM ' . $table . '');
        return $req;
    }

    public function add($table, $fields, $value, $data)
    {//CREATE
        $db = $this->server();
        $req = $db->prepare('INSERT INTO ' . $table . '(' . $fields . ') VALUES (' . $value . ')');
        $req->execute($data);
    }

    public function update($table, $fields, $condition, $data)
    {//UPDATE
        $db = $this->server();
        $req = $db->prepare('UPDATE ' . $table . ' SET ' . $fields . ' WHERE ' . $condition . '');
        $req->execute($data);
    }

    public function delete($table, $condition, $data)
    {//DELETE
        $db = $this->server();
        $req = $db->prepare('DELETE FROM ' . $table . ' WHERE ' . $condition . '');
        $req->execute($data);
    }
    //FIN CRUD

    public function search($table, $fields, $condition, $data){
        $db = $this -> server();
        $req = $db -> prepare('SELECT '.$fields.' FROM '.$table.' WHERE '.$condition.'');
            //SELECT * FROM cinema WHERE id = ? OR titre LIKE CONCAT('%', ?, '%')
        $req ->execute($data);
        return $req;
    }
}






?>