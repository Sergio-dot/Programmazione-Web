<?php

class Categoria
{
    // database connection
    private $conn;

    // object properties
    public $id_categoria;
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
        $query = "SELECT * FROM categoria ORDER BY id_categoria ASC";

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
        $query = "INSERT INTO categoria SET nome = :nome";

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
        $query = "SELECT * FROM categoria WHERE id_categoria = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_categoria);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_categoria = $row['id_categoria'];
        $this->nome = $row['nome'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE categoria SET nome = :nome WHERE id_categoria = :id_categoria";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind new values
        $stmt->bindParam(':id_categoria', $this->id_categoria);
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
        $query = "DELETE FROM categoria WHERE id_categoria = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_categoria);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
