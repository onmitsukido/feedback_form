<?php

namespace App\Models;

use App\Services\Database;

class Feedback
{

    public static function save(int $clientId, int $rating, ?string $comment = null): bool
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5.');
        }

        $safeComment = $comment === null ? null : htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO feedbacks (client_id, rating, comment)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([$clientId, $rating, $safeComment]);
    }
}