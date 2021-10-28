<?php

class Ordine
{
    // database connection
    private $conn;

    // object properties
    public $id_ordine;
    public $id_fornitore;
    public $stato;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM ordine ORDER BY id_ordine ASC";

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
        $query = "INSERT INTO ordine 
                    SET id_fornitore = :id_fornitore,
                        stato = '0'";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_fornitore = htmlspecialchars(strip_tags($this->id_fornitore));

        // bind values
        $stmt->bindParam(":id_fornitore", $this->id_fornitore);

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
        $query = "SELECT * FROM ordine WHERE id_ordine = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_ordine);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_ordine = $row['id_ordine'];
        $this->id_fornitore = $row['id_fornitore'];
        $this->stato = $row['stato'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE ordine 
                    SET id_fornitore = :id_fornitore,
                        stato = :stato
                    WHERE id_ordine = :id_ordine";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));
        $this->id_fornitore = htmlspecialchars(strip_tags($this->id_fornitore));
        $this->stato = htmlspecialchars(strip_tags($this->stato));

        // bind new values
        $stmt->bindParam(':id_ordine', $this->id_ordine);
        $stmt->bindParam(':id_fornitore', $this->id_fornitore);
        $stmt->bindParam(':stato', $this->stato);

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
        $query = "DELETE FROM ordine WHERE id_ordine = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ordine = htmlspecialchars(strip_tags($this->id_ordine));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_ordine);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // select last created
    function maxId()
    {
        // SQL query
        $query = "SELECT MAX(id_ordine) AS id_ordine FROM ordine";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
