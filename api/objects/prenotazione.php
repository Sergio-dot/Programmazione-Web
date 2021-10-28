<?php

class Prenotazione
{
    // database connection
    private $conn;

    // object properties
    public $id_prenotazione;
    public $id_tavolo;
    public $nome;
    public $cognome;
    public $data_prenotazione;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select query
        $query = "SELECT prenotazione.id_prenotazione, prenotazione.id_tavolo, prenotazione.nome, prenotazione.cognome, prenotazione.data_prenotazione
                    FROM prenotazione
                    ORDER BY id_prenotazione ASC";

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
        $query = "INSERT INTO prenotazione SET id_tavolo = :id_tavolo, nome = :nome, cognome = :cognome, data_prenotazione = :data_prenotazione";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));
        $this->data_prenotazione = htmlspecialchars(strip_tags($this->data_prenotazione));

        // bind values
        $stmt->bindParam(":id_tavolo", $this->id_tavolo);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cognome", $this->cognome);
        $stmt->bindParam(":data_prenotazione", $this->data_prenotazione);

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
        $query = "SELECT prenotazione.id_prenotazione, prenotazione.id_tavolo, prenotazione.nome, prenotazione.cognome, prenotazione.data_prenotazione
                    FROM prenotazione
                    WHERE id_prenotazione = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_prenotazione);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_prenotazione = $row['id_prenotazione'];
        $this->id_tavolo = $row['id_tavolo'];
        $this->nome = $row['nome'];
        $this->cognome = $row['cognome'];
        $this->data_prenotazione = $row['data_prenotazione'];
    }

    // update a record
    function update()
    {
        // sql query
        $query = "UPDATE prenotazione SET id_tavolo = :id_tavolo, nome = :nome, cognome = :cognome, data_prenotazione = :data_prenotazione
                    WHERE id_prenotazione = :id_prenotazione";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_prenotazione = htmlspecialchars(strip_tags($this->id_prenotazione));
        $this->id_tavolo = htmlspecialchars(strip_tags($this->id_tavolo));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));
        $this->data_prenotazione = htmlspecialchars(strip_tags($this->data_prenotazione));

        // bind new values
        $stmt->bindParam(':id_prenotazione', $this->id_prenotazione);
        $stmt->bindParam(':id_tavolo', $this->id_tavolo);
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cognome', $this->cognome);
        $stmt->bindParam(':data_prenotazione', $this->data_prenotazione);

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
        $query = "DELETE FROM prenotazione WHERE id_prenotazione = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_prenotazione = htmlspecialchars(strip_tags($this->id_prenotazione));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_prenotazione);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
