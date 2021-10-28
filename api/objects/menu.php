<?php

class Menu
{
    // database connection
    private $conn;

    // object properties
    public $id_menu;
    public $nome;
    public $prezzo;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM menu ORDER BY id_menu ASC";

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
        $query = "INSERT INTO menu 
                    SET nome = :nome,
                        prezzo = :prezzo";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->prezzo = htmlspecialchars(strip_tags($this->prezzo));

        // bind values
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":prezzo", $this->prezzo);

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
        $query = "SELECT * FROM menu WHERE id_menu = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_menu);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_menu = $row['id_menu'];
        $this->nome = $row['nome'];
        $this->prezzo = $row['prezzo'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE menu 
                    SET nome = :nome,
                        prezzo = :prezzo
                    WHERE id_menu = :id_menu";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_menu = htmlspecialchars(strip_tags($this->id_menu));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->prezzo = htmlspecialchars(strip_tags($this->prezzo));

        // bind new values
        $stmt->bindParam(':id_menu', $this->id_menu);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':prezzo', $this->prezzo);

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
        $query = "DELETE FROM menu WHERE id_menu = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_menu = htmlspecialchars(strip_tags($this->id_menu));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_menu);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
