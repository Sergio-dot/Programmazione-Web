<?php

class Ingrediente
{
    // database connection
    private $conn;

    // object properties
    public $id_ingrediente;
    public $id_categoria;
    public $id_ambiente;
    public $nome;
    public $quantita;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // SQL query
        $query = "SELECT * FROM ingrediente ORDER BY id_ingrediente ASC";

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
        $query = "INSERT INTO ingrediente 
                    SET id_categoria = :id_categoria, 
                        id_ambiente = :id_ambiente, 
                        id_ordine = :id_ordine, 
                        nome = :nome, 
                        quantita = :quantita";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));

        // bind values
        $stmt->bindParam(":id_categoria", $this->id_categoria);
        $stmt->bindParam(":id_ambiente", $this->id_ambiente);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":quantita", $this->quantita);

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
        $query = "SELECT * FROM ingrediente WHERE id_ingrediente = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_ingrediente);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_ingrediente = $row['id_ingrediente'];
        $this->id_categoria = $row['id_categoria'];
        $this->id_ambiente = $row['id_ambiente'];
        $this->nome = $row['nome'];
        $this->quantita = $row['quantita'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE ingrediente 
                    SET id_categoria = :id_categoria, 
                        id_ambiente = :id_ambiente, 
                        nome = :nome, 
                        quantita = :quantita 
                    WHERE id_ingrediente = :id_ingrediente";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));
        $this->id_categoria = htmlspecialchars(strip_tags($this->id_categoria));
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));

        // bind new values
        $stmt->bindParam(':id_ingrediente', $this->id_ingrediente);
        $stmt->bindParam(':id_categoria', $this->id_categoria);
        $stmt->bindParam(':id_ambiente', $this->id_ambiente);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':quantita', $this->quantita);

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
        $query = "DELETE FROM ingrediente WHERE id_ingrediente = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_ingrediente);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
