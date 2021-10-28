<?php

class Tavolo
{
    // database connection
    private $conn;

    // object properties
    public $id_tavolo;
    public $id_ambiente;
    public $posti;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select query
        $query = "SELECT tavolo.id_tavolo, tavolo.id_ambiente, ambiente.nome AS nome_ambiente, tavolo.posti
                    FROM tavolo, ambiente
                    WHERE tavolo.id_ambiente = ambiente.id_ambiente
                    ORDER BY id_tavolo ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create new record
    function create()
    {
        // sql query
        $query = "INSERT INTO tavolo SET id_ambiente = :id_ambiente, posti = :posti";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));
        $this->posti = htmlspecialchars(strip_tags($this->posti));

        // bind values
        $stmt->bindParam(":id_ambiente", $this->id_ambiente);
        $stmt->bindParam(":posti", $this->posti);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // used when filling up the update form
    function readOne()
    {
        // sql query
        $query = "SELECT tavolo.id_tavolo, tavolo.id_ambiente, ambiente.nome AS nome_ambiente, tavolo.posti
                    FROM tavolo, ambiente
                    WHERE tavolo.id_ambiente = ambiente.id_ambiente
                    AND id_tavolo = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_tavolo);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_tavolo = $row['id_tavolo'];
        $this->id_ambiente = $row['id_ambiente'];
        $this->posti = $row['posti'];
        $this->nome_ambiente = $row['nome_ambiente'];
    }

    // update a record
    function update()
    {
        // sql query
        $query = "UPDATE tavolo 
                    SET id_ambiente = :id_ambiente, posti = :posti
                    WHERE id_tavolo = :id_tavolo";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));
        $this->posti = htmlspecialchars(strip_tags($this->posti));

        // bind new values
        $stmt->bindParam(':id_tavolo', $this->id_tavolo);
        $stmt->bindParam(':id_ambiente', $this->id_ambiente);
        $stmt->bindParam(':posti', $this->posti);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete a record
    function delete()
    {
        // sql query
        $query = "DELETE FROM tavolo WHERE id_tavolo = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_tavolo);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
