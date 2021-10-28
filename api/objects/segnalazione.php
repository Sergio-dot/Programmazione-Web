<?php

class Segnalazione
{
    // database connection
    private $conn;

    // object properties
    public $id_segnalazione;
    public $id_chef;
    public $ingrediente;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT segnalazione.id_segnalazione AS id_segnalazione, segnalazione.id_chef AS id_chef, segnalazione.ingrediente AS ingrediente,
                    ingrediente.id_ingrediente AS id_ingrediente
                    FROM segnalazione, ingrediente WHERE segnalazione.ingrediente = ingrediente.nome";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function readFornitore()
    {
        // SQL query
        $query = "SELECT segnalazione.id_segnalazione AS id_segnalazione, segnalazione.id_chef AS id_chef, segnalazione.ingrediente AS ingrediente,
                    ingrediente.id_ingrediente AS id_ingrediente
                    FROM segnalazione, ingrediente WHERE segnalazione.ingrediente = ingrediente.nome";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // create new record
    function create()
    {
        // sql query
        $query = "INSERT INTO segnalazione 
                    SET id_chef = :id_chef,
                        ingrediente = :ingrediente";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_chef = htmlspecialchars(strip_tags($this->id_chef));
        $this->ingrediente = htmlspecialchars(strip_tags($this->ingrediente));

        // bind values
        $stmt->bindParam(":id_chef", $this->id_chef);
        $stmt->bindParam(":ingrediente", $this->ingrediente);

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
        $query = "SELECT * FROM segnalazione WHERE id_segnalazione = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_segnalazione);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_segnalazione = $row['id_segnalazione'];
        $this->id_chef = $row['id_chef'];
        $this->ingrediente = $row['ingrediente'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE segnalazione 
                    SET id_chef = :id_chef,
                        ingrediente = :ingrediente
                    WHERE id_segnalazione = :id_segnalazione";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_segnalazione = htmlspecialchars(strip_tags($this->id_segnalazione));
        $this->id_chef = htmlspecialchars(strip_tags($this->id_chef));
        $this->ingrediente = htmlspecialchars(strip_tags($this->ingrediente));

        // bind new values
        $stmt->bindParam(':id_segnalazione', $this->id_segnalazione);
        $stmt->bindParam(':id_chef', $this->id_chef);
        $stmt->bindParam(':ingrediente', $this->ingrediente);

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
        $query = "DELETE FROM segnalazione WHERE id_segnalazione = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_segnalazione = htmlspecialchars(strip_tags($this->id_segnalazione));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_segnalazione);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
