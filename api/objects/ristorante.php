<?php

class Ristorante
{
    // database connection
    private $conn;

    // object properties
    public $id_ristorante;
    public $nome;
    public $telefono;
    public $indirizzo;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM ristorante ORDER BY id_ristorante ASC";

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
        $query = "INSERT INTO ristorante SET nome = :nome, telefono = :telefono, indirizzo = :indirizzo";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->indirizzo = htmlspecialchars(strip_tags($this->indirizzo));

        // bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":telefono", $this->telefono);
        $stmt->bindParam(":indirizzo", $this->indirizzo);

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
        $query = "SELECT * FROM ristorante WHERE id_ristorante = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_ristorante);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_ristorante = $row['id_ristorante'];
        $this->nome = $row['nome'];
        $this->telefono = $row['telefono'];
        $this->indirizzo = $row['indirizzo'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE ristorante SET nome = :nome, telefono = :telefono, indirizzo = :indirizzo WHERE id_ristorante = :id_ristorante";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->indirizzo = htmlspecialchars(strip_tags($this->indirizzo));

        // bind new values
        $stmt->bindParam(':id_ristorante', $this->id_ristorante);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':indirizzo', $this->indirizzo);

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
        $query = "DELETE FROM ristorante WHERE id_ristorante = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_ristorante);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
