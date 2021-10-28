<?php

class Genere
{
    // database connection
    private $conn;

    // object properties
    public $id_genere;
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
        $query = "SELECT * FROM genere ORDER BY id_genere ASC";

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
        $query = "INSERT INTO genere SET nome=:nome";

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
        $query = "SELECT * FROM genere WHERE id_genere = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_genere);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_genere = $row['id_genere'];
        $this->nome = $row['nome'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE genere SET nome = :nome WHERE id_genere = :id_genere";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_genere = htmlspecialchars(strip_tags($this->id_genere));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind new values
        $stmt->bindParam(':id_genere', $this->id_genere);
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
        $query = "DELETE FROM genere WHERE id_genere = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_genere = htmlspecialchars(strip_tags($this->id_genere));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_genere);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
