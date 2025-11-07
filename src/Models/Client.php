<?php

namespace App\Models;

use App\Services\Database;

class Client
{
    public static function exists(int $id): bool
    {
        if ($id <= 0) {
            return false;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT 1 FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        return (bool) $stmt->fetchColumn();
    }
}