<?php

class DettagliOrdine
{
    // database connection
    private $conn;

    // object properties
    public $id_det_ordine;
    public $id_ordine;
    public $id_ingrediente;
    public $quantita;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM dettagli_ordine ORDER BY id_det_ordine ASC";

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
        $query = "INSERT INTO dettagli_ordine 
                    SET id_ordine = :id_ordine,
                        id_ingrediente = :id_ingrediente,
                        quantita = :quantita";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));

        // bind values
        $stmt->bindParam(":id_ordine", $this->id_ordine);
        $stmt->bindParam(":id_ingrediente", $this->id_ingrediente);
        $stmt->bindParam(":quantita", $this->quantita);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // used when filling up update form
    function readOne()
    {
        // sql query
        $query = "SELECT * FROM dettagli_ordine WHERE id_det_ordine = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_det_ordine);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_det_ordine = $row['id_det_ordine'];
        $this->id_ordine = $row['id_ordine'];
        $this->id_ingrediente = $row['id_ingrediente'];
        $this->quantita = $row['quantita'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE dettagli_ordine 
                    SET id_ordine = :id_ordine,
                        id_ingrediente = :id_ingrediente,
                        quantita = :quantita
                    WHERE id_det_ordine = :id_det_ordine";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_det_ordine = htmlspecialchars(strip_tags($this->id_det_ordine));
        $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));
        $this->id_ingrediente = htmlspecialchars(strip_tags($this->id_ingrediente));
        $this->quantita = htmlspecialchars(strip_tags($this->quantita));

        // bind new values
        $stmt->bindParam(':id_det_ordine', $this->id_det_ordine);
        $stmt->bindParam(':id_ordine', $this->id_ordine);
        $stmt->bindParam(':id_ingrediente', $this->id_ingrediente);
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
        $query = "DELETE FROM dettagli_ordine WHERE id_det_ordine = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_det_ordine = htmlspecialchars(strip_tags($this->id_det_ordine));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_det_ordine);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
