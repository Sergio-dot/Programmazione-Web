<?php

class Tipologia
{
    // database connection
    private $conn;

    // object properties
    public $id_tipologia;
    public $nome;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM tipologia ORDER BY id_tipologia ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create a new record
    function create()
    {
        // SQL query
        $query = "INSERT INTO tipologia SET nome=:nome";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind value
        $stmt->bindParam(":nome", $this->nome);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // used when filling up the update form
    function readOne()
    {
        // SQL query
        $query = "SELECT * FROM tipologia WHERE id_tipologia = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_tipologia);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_tipologia = $row['id_tipologia'];
        $this->nome = $row['nome'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE tipologia SET nome = :nome WHERE id_tipologia = :id_tipologia";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tipologia = htmlspecialchars(strip_tags($this->id_tipologia));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind new values
        $stmt->bindParam(':id_tipologia', $this->id_tipologia);
        $stmt->bindParam(':nome', $this->nome);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete a record
    function delete()
    {
        // SQL query
        $query = "DELETE FROM tipologia WHERE id_tipologia = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tipologia = htmlspecialchars(strip_tags($this->id_tipologia));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_tipologia);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
