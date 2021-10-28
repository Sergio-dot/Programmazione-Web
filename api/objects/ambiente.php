<?php

class Ambiente
{
    // database connection
    private $conn;

    // object properties
    public $id_ambiente;
    public $id_ristorante;
    public $id_tipologia;
    public $nome;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read all records
    function read()
    {
        // select query
        $query = "SELECT ambiente.id_ambiente, ambiente.id_ristorante, ambiente.id_tipologia, ambiente.nome, ristorante.nome AS nome_ristorante, tipologia.nome AS nome_tipologia
                    FROM ambiente, ristorante, tipologia
                    WHERE ambiente.id_ristorante = ristorante.id_ristorante
                    AND ambiente.id_tipologia = tipologia.id_tipologia
                    ORDER BY id_ambiente ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create a new record
    function create()
    {
        // sql query
        $query = "INSERT INTO ambiente SET id_ristorante = :id_ristorante, id_tipologia = :id_tipologia, nome = :nome";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));
        $this->id_tipologia = htmlspecialchars(strip_tags($this->id_tipologia));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind values
        $stmt->bindParam(":id_ristorante", $this->id_ristorante);
        $stmt->bindParam(":id_tipologia", $this->id_tipologia);
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
        $query = "SELECT ambiente.id_ambiente, ambiente.id_ristorante, ambiente.id_tipologia, ambiente.nome, ristorante.nome AS nome_ristorante, tipologia.nome AS nome_tipologia
                    FROM ambiente, ristorante, tipologia
                    WHERE ambiente.id_ristorante = ristorante.id_ristorante
                    AND ambiente.id_tipologia = tipologia.id_tipologia
                    AND id_ambiente = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_ambiente);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_ambiente = $row['id_ambiente'];
        $this->id_ristorante = $row['id_ristorante'];
        $this->id_tipologia = $row['id_tipologia'];
        $this->nome = $row['nome'];
        $this->nome_ristorante = $row['nome_ristorante'];
        $this->nome_tipologia = $row['nome_tipologia'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE ambiente SET id_ristorante = :id_ristorante, id_tipologia = :id_tipologia, nome = :nome WHERE id_ambiente = :id_ambiente";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));
        $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));
        $this->id_tipologia = htmlspecialchars(strip_tags($this->id_tipologia));
        $this->nome = htmlspecialchars(strip_tags($this->nome));

        // bind new values
        $stmt->bindParam(':id_ambiente', $this->id_ambiente);
        $stmt->bindParam(':id_ristorante', $this->id_ristorante);
        $stmt->bindParam(':id_tipologia', $this->id_tipologia);
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
        $query = "DELETE FROM ambiente WHERE id_ambiente = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_ambiente = htmlspecialchars(strip_tags($this->id_ambiente));

        // bind id of record to be deleted
        $stmt->bindParam(1, $this->id_ambiente);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
