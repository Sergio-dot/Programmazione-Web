<?php

class Utente
{
    // database connection and table name
    private $conn;

    public $id;
    public $id_ristorante;
    public $id_genere;
    public $ruolo;
    public $nome;
    public $cognome;
    public $email;
    public $password;
    public $data_nascita;

    // constructor
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // check if email given in input exists in the database
    function emailExists()
    {
        if ($this->ruolo == "chef" || $this->ruolo == "Chef") {
            // select query per chef
            $query = "SELECT id_chef, nome, cognome, password
                        FROM chef
                        WHERE email = ?
                        LIMIT 0,1";
        } else if ($this->ruolo == "cameriere" || $this->ruolo == "Cameriere") {
            // select query per cameriere
            $query = "SELECT id_cameriere, nome, cognome, password
                        FROM cameriere
                        WHERE email = ?
                        LIMIT 0,1";
        } else if ($this->ruolo == "fornitore" || $this->ruolo == "Fornitore") {
            // select query per fornitore
            $query = "SELECT id_fornitore, id_genere, nome, password
                        FROM fornitore
                        WHERE email = ?
                        LIMIT 0,1";
        } else if ($this->ruolo == "admin" || $this->ruolo == "Admin") {
            // select query per admin
            $query = "SELECT id_admin, nome, cognome, password
                        FROM admin
                        WHERE email = ?
                        LIMIT 0,1";
        }

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));

        // bind email value given in input
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if ($num > 0) {
            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            if ($this->ruolo == "chef" || $this->ruolo == "Chef") { // ruolo: chef
                $this->id = $row['id_chef'];
                $this->nome = $row['nome'];
                $this->cognome = $row['cognome'];
                $this->password = $row['password'];
            } else if ($this->ruolo == "cameriere" || $this->ruolo == "Cameriere") { // ruolo: cameriere
                $this->id = $row['id_cameriere'];
                $this->nome = $row['nome'];
                $this->cognome = $row['cognome'];
                $this->password = $row['password'];
            } else if ($this->ruolo == "fornitore" || $this->ruolo == "Fornitore") { // ruolo: fornitore
                $this->id = $row['id_fornitore'];
                $this->nome = $row['nome'];
                $this->password = $row['password'];
            } else if ($this->ruolo == "admin" || $this->ruolo == "Admin") { // ruolo: admin
                $this->id = $row['id_admin'];
                $this->nome = $row['nome'];
                $this->cognome = $row['cognome'];
                $this->password = $row['password'];
            }

            // return true because in this case email exists in the database
            return true;
        }
        // return false because in this case email does not exists in the database
        return false;
    }

    // create new user record
    function create()
    {
        if ($this->ruolo == "chef" || $this->ruolo == "cameriere" || $this->ruolo == "Chef" || $this->ruolo == "Cameriere") {
            if ($this->ruolo == "chef" || $this->ruolo == "Chef") {
                // insert query for chefs
                $query = "INSERT INTO chef
                            SET
                                id_ristorante = :id_ristorante,
                                nome = :nome,
                                cognome = :cognome,
                                email = :email,
                                password = :password,
                                data_nascita = :data_nascita";
            } else if ($this->ruolo == "cameriere" || $this->ruolo == "Cameriere") {
                // insert query for waiters
                $query = "INSERT INTO cameriere
                        SET
                            id_ristorante = :id_ristorante,
                            nome = :nome,
                            cognome = :cognome,
                            email = :email,
                            password = :password,
                            data_nascita = :data_nascita";
            }

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id_ristorante = htmlspecialchars(strip_tags($this->id_ristorante));
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->cognome = htmlspecialchars(strip_tags($this->cognome));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->data_nascita = htmlspecialchars(strip_tags($this->data_nascita));

            // bind values
            $stmt->bindParam(':id_ristorante', $this->id_ristorante);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':cognome', $this->cognome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':data_nascita', $this->data_nascita);

            // hash the password before storing into database
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        } else if ($this->ruolo == "fornitore" || $this->ruolo == "Fornitore") {
            $query = "INSERT INTO fornitore
                        SET
                            id_genere = :id_genere,
                            nome = :nome,
                            email = :email,
                            password = :password";

            // prepare query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id_genere = htmlspecialchars(strip_tags($this->id_genere));
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // bind values
            $stmt->bindParam(':id_genere', $this->id_genere);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);

            // hash the password before storing into database
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $password_hash);
        }

        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // update a user record
    public function update()
    {
        // if password needs to be updated
        $password_set = !empty($this->password) ? "password = :password" : "";

        // if no posted password, do not update the password
        if ($this->ruolo == "chef" || $this->ruolo == "cameriere") {
            if ($this->ruolo == "chef") { // if user to be edited is chef
                $query = "UPDATE chef
                            SET
                                nome = :nome,
                                cognome = :cognome,
                                email = :email,
                                {$password_set},
                                data_nascita = :data_nascita
                            WHERE id_chef = :id";
            } else if ($this->ruolo == "cameriere") { // if user to be edited is cameriere
                $query = "UPDATE cameriere
                            SET
                                nome = :nome,
                                cognome = :cognome,
                                email = :email,
                                {$password_set},
                                data_nascita = :data_nascita
                            WHERE id_cameriere = :id";
            }

            // prepare the query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->cognome = htmlspecialchars(strip_tags($this->cognome));
            $this->data_nascita = htmlspecialchars(strip_tags($this->data_nascita));

            // bind the values from the form
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':cognome', $this->cognome);
            $stmt->bindParam(':data_nascita', $this->data_nascita);

            // hash the password before storing into database
            if (!empty($this->password)) {
                $this->password = htmlspecialchars(strip_tags($this->password));
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }

            // unique id of record to be edited
            $stmt->bindParam(':id', $this->id);
        } else if ($this->ruolo == "fornitore") {
            $query = "UPDATE fornitore
                            SET
                                id_genere = :id_genere,
                                nome = :nome,
                                email = :email,
                                {$password_set}
                            WHERE id_fornitore = :id";

            // prepare the query
            $stmt = $this->conn->prepare($query);

            // sanitize
            $this->id_genere = htmlspecialchars(strip_tags($this->id_genere));
            $this->nome = htmlspecialchars(strip_tags($this->nome));
            $this->email = htmlspecialchars(strip_tags($this->email));

            // bind the values from the form
            $stmt->bindParam(':id_genere', $this->id_genere);
            $stmt->bindParam(':nome', $this->nome);
            $stmt->bindParam(':email', $this->email);

            // hash the password before storing into database
            if (!empty($this->password)) {
                $this->password = htmlspecialchars(strip_tags($this->password));
                $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
                $stmt->bindParam(':password', $password_hash);
            }

            // unique id of record to be edited
            $stmt->bindParam(':id', $this->id);
        }


        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete user record
    public function delete()
    {
        // delete query
        if ($this->ruolo == "cameriere" || $this->ruolo == "Cameriere") {
            $query = "DELETE FROM " . $this->ruolo . " WHERE id_cameriere = :id";
        } else if ($this->ruolo == "chef" || $this->ruolo == "Chef") {
            $query = "DELETE FROM " . $this->ruolo . " WHERE id_chef = :id";
        } else if ($this->ruolo == "fornitore" || $this->ruolo == "Fornitore") {
            $query = "DELETE FROM " . $this->ruolo . " WHERE id_fornitore = :id";
        }

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // unique id of record to be deleted
        $stmt->bindParam(':id', $this->id);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // read records from cameriere
    public function read_cameriere()
    {
        // read query
        $query = "SELECT cameriere.id_cameriere, cameriere.id_ristorante, ristorante.nome AS nome_ristorante, cameriere.nome, cameriere.cognome, cameriere.email, cameriere.data_nascita
                    FROM cameriere, ristorante
                    WHERE cameriere.id_ristorante = ristorante.id_ristorante";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query
        $stmt->execute();

        return $stmt;
    }

    // read records from chef
    public function read_chef()
    {
        // read query
        $query = "SELECT chef.id_chef, chef.id_ristorante, ristorante.nome AS nome_ristorante, chef.nome, chef.cognome, chef.email, chef.data_nascita
                    FROM chef, ristorante 
                    WHERE chef.id_ristorante = ristorante.id_ristorante";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query
        $stmt->execute();

        return $stmt;
    }

    // read records from fornitore
    public function read_fornitore()
    {
        // read query
        $query = "SELECT fornitore.id_fornitore, fornitore.id_genere, genere.nome AS nome_genere, fornitore.nome, fornitore.email
                    FROM fornitore, genere
                    WHERE fornitore.id_genere = genere.id_genere";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // execute the query
        $stmt->execute();

        return $stmt;
    }

    // read one record from cameriere through ID
    public function read_one_cameriere()
    {
        // query to read single record
        $query = "SELECT cameriere.id_cameriere, cameriere.id_ristorante, ristorante.nome AS nome_ristorante, cameriere.nome, cameriere.cognome, cameriere.email, cameriere.data_nascita
                    FROM cameriere, ristorante
                    WHERE cameriere.id_ristorante = ristorante.id_ristorante AND cameriere.id_cameriere = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of user to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrived row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // check if record is found
        $num = $stmt->rowCount();

        // set values to object properties
        $this->id = $row['id_cameriere'];
        $this->id_ristorante = $row['id_ristorante'];
        $this->nome_ristorante = $row['nome_ristorante'];
        $this->nome = $row['nome'];
        $this->cognome = $row['cognome'];
        $this->email = $row['email'];
        $this->data_nascita = $row['data_nascita'];
    }

    // read one record from chef through ID
    public function read_one_chef()
    {
        $query = "SELECT chef.id_chef, chef.id_ristorante, ristorante.nome AS nome_ristorante, chef.nome, chef.cognome, chef.email, chef.data_nascita
                    FROM chef, ristorante
                    WHERE chef.id_ristorante = ristorante.id_ristorante AND chef.id_chef = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of user to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrived row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // check if record is found
        $num = $stmt->rowCount();

        // set values to object properties
        $this->id = $row['id_chef'];
        $this->id_ristorante = $row['id_ristorante'];
        $this->nome_ristorante = $row['nome_ristorante'];
        $this->nome = $row['nome'];
        $this->cognome = $row['cognome'];
        $this->email = $row['email'];
        $this->data_nascita = $row['data_nascita'];
    }

    // read one record from fornitore through ID
    public function read_one_fornitore()
    {
        $query = "SELECT fornitore.id_fornitore, fornitore.id_genere, genere.nome AS nome_genere, fornitore.nome, fornitore.email
                    FROM fornitore, genere
                    WHERE fornitore.id_genere = genere.id_genere AND fornitore.id_fornitore = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of user to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrived row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // check if record is found
        $num = $stmt->rowCount();

        // set values to object properties
        $this->id = $row['id_fornitore'];
        $this->id_genere = $row['id_genere'];
        $this->nome_genere = $row['nome_genere'];
        $this->nome = $row['nome'];
        $this->email = $row['email'];
    }
}
