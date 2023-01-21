<?php

class BeveragesGateway
{
    private PDO $conn;

    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT *
                FROM beverages";

        $stmt = $this->conn->query($sql);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $row["is_available"] = (bool) $row["is_available"];
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        session_start();

        // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: front/login.php");
            exit;
        }
        $sql = "INSERT INTO beverages (name, ingredients, is_available)
                VALUES (:name, :ingredients, :is_available)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(":ingredients", $data["ingredients"] ?? 0, PDO::PARAM_INT);
        $stmt->bindValue(":is_available", (bool) ($data["is_available"] ?? false), PDO::PARAM_BOOL);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function get(string $id): array | false
    {
        $sql = "SELECT *
                FROM beverages
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["is_available"] = (bool) $data["is_available"];
        }

        return $data;
    }

    public function update(array $current, array $new): int
    {

        // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: front/login.php");
            exit;
        }
        $sql = "UPDATE beverages
                SET name = :name, ingredients = :ingredients, is_available = :is_available
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":name", $new["name"] ?? $current["name"], PDO::PARAM_STR);
        $stmt->bindValue(":ingredients", $new["ingredients"] ?? $current["ingredients"], PDO::PARAM_INT);
        $stmt->bindValue(":is_available", $new["is_available"] ?? $current["is_available"], PDO::PARAM_BOOL);

        $stmt->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public function delete(string $id): int
    {

        // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
        if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
            header("location: front/login.php");
            exit;
        }
        $sql = "DELETE FROM beverages
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
}
