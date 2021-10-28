<?php

class dettagliComanda
{
    // database connection
    private $conn;

    // object properties
    public $id_det_comanda;
    public $id_comanda;
    public $id_menu;
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
        $query = "SELECT comanda.id_comanda, comanda.id_tavolo, menu.id_menu, menu.nome, menu.prezzo, dettagli_comanda.id_det_comanda, dettagli_comanda.stato
                    FROM comanda, menu, dettagli_comanda
                    WHERE comanda.id_comanda = dettagli_comanda.id_comanda
                    AND menu.id_menu = dettagli_comanda.id_menu
                    ORDER BY dettagli_comanda.id_det_comanda ASC";

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
        $query = "INSERT INTO dettagli_comanda 
                    SET id_comanda = :id_comanda,
                        id_menu = :id_menu,
                        stato = '0'";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_comanda = htmlspecialchars(strip_tags($this->id_comanda));
        $this->id_menu = htmlspecialchars(strip_tags($this->id_menu));

        // bind values
        $stmt->bindParam(":id_comanda", $this->id_comanda);
        $stmt->bindParam(":id_menu", $this->id_menu);

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
        $query = "SELECT * FROM dettagli_comanda WHERE id_det_comanda = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of record to be updated
        $stmt->bindParam(1, $this->id_det_comanda);

        // execute query
        $stmt->execute();

        // fetch
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id_det_comanda = $row['id_det_comanda'];
        $this->id_comanda = $row['id_comanda'];
        $this->id_menu = $row['id_menu'];
        $this->stato = $row['stato'];
    }

    // update a record
    function update()
    {
        // SQL query
        $query = "UPDATE dettagli_comanda 
                    SET id_comanda = :id_comanda,
                        id_menu = :id_menu,
                        stato = :stato
                    WHERE id_det_comanda = :id_det_comanda";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_det_comanda = htmlspecialchars(strip_tags($this->id_det_comanda));
        $this->id_comanda = htmlspecialchars(strip_tags($this->id_comanda));
        $this->id_menu = htmlspecialchars(strip_tags($this->id_menu));
        $this->stato = htmlspecialchars(strip_tags($this->stato));

        // bind values
        $stmt->bindParam(':id_det_comanda', $this->id_det_comanda);
        $stmt->bindParam(':id_comanda', $this->id_comanda);
        $stmt->bindParam(':id_menu', $this->id_menu);
        $stmt->bindParam(':stato', $this->stato);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function ready()
    {
        // SQL query
        $query = "UPDATE dettagli_comanda
                    SET stato = '1'
                    WHERE id_det_comanda = :id_det_comanda";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_det_comanda = htmlspecialchars(strip_tags($this->id_det_comanda));

        // bind value
        $stmt->bindParam(':id_det_comanda', $this->id_det_comanda);

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
        $query = "DELETE FROM dettagli_comanda 
                    WHERE id_det_comanda = :id_det_comanda AND id_comanda = :id_comanda AND id_menu = :id_menu LIMIT 1";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_det_comanda = htmlspecialchars(strip_tags($this->id_det_comanda));
        $this->id_comanda = htmlspecialchars(strip_tags($this->id_comanda));
        $this->id_menu = htmlspecialchars(strip_tags($this->id_menu));

        // bind values
        $stmt->bindParam(":id_det_comanda", $this->id_det_comanda);
        $stmt->bindParam(":id_comanda", $this->id_comanda);
        $stmt->bindParam(":id_menu", $this->id_menu);

        // execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
