<?php

class BeveragesController
{
    public function __construct(private BeveragesGateway $gateway)
    {
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {

            $this->processResourceRequest($method, $id);
        } else {

            $this->processCollectionRequest($method);
        }
    }

    private function processResourceRequest(string $method, string $id): void
    {
        $beverage = $this->gateway->get($id);

        if (!$beverage) {
            http_response_code(404);
            echo json_encode(["message" => "Beverage not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($beverage);
                break;

            case "PATCH":
                session_start();

                // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
                if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                    header("location: front/login.php");
                    exit;
                }
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data, false);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($beverage, $data);

                echo json_encode([
                    "message" => "Beverage $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                session_start();

                // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
                if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                    header("location: front/login.php");
                    exit;
                }
                $rows = $this->gateway->delete($id);

                echo json_encode([
                    "message" => "Beverage $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");
        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                session_start();

                // Sprawdzenie czy użytkownik jest zalogowany, jeśli nie to następuje przeniesienie go do strony logowania
                if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
                    header("location: front/login.php");
                    exit;
                }
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $errors = $this->getValidationErrors($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Beverage created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];

        if ($is_new && empty($data["name"])) {
            $errors[] = "Name is required";
        }
        if ($is_new && empty($data["ingredients"])) {
            $errors[] = "Ingredients are required";
        }

        return $errors;
    }
}
