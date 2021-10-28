<?php

class comanda
{
    // database connection
    private $conn;

    // object properties
    public $id_comanda;
    public $id_tavolo;
    public $data_creazione;
    public $ultima_modifica;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select all query
        $query = "SELECT * FROM comanda ORDER BY id_comanda ASC";

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
        $query = "INSERT INTO comanda SET id_tavolo = :id_tavolo";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));

        // bind values
        $stmt->bindParam(":id_tavolo", $this->id_tavolo);

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
        $query = "SELECT * FROM comanda WHERE id_comanda = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_comanda);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_comanda = $row['id_comanda'];
        $this->id_tavolo = $row['id_tavolo'];
        $this->ultima_modifica = $row['ultima_modifica'];
        $this->data_creazione = $row['data_creazione'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE comanda SET id_tavolo = :id_tavolo WHERE id_comanda = :id_comanda";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_comanda = htmlspecialchars(strip_tags($this->id_comanda));
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));

        // bind new values
        $stmt->bindParam(':id_comanda', $this->id_comanda);
        $stmt->bindParam(':id_tavolo', $this->id_tavolo);

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
        $query = "DELETE FROM comanda WHERE id_comanda = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_comanda = htmlspecialchars(strip_tags($this->id_comanda));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_comanda);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // function to see all dishes linked to an order
    function read_dettagli()
    {
        // SQL query
        $query = "SELECT comanda.id_comanda, comanda.id_tavolo, menu.id_menu, menu.nome, menu.prezzo, dettagli_comanda.id_det_comanda, dettagli_comanda.stato
                    FROM comanda, menu, dettagli_comanda
                    WHERE comanda.id_comanda = dettagli_comanda.id_comanda
                        AND menu.id_menu = dettagli_comanda.id_menu
                        AND comanda.id_comanda = :id_comanda";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // bind id of table to analyze
        $stmt->bindParam(":id_comanda", $this->id_comanda);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
