<?php

namespace App\Surveys;

use App\Interfaces\SurveyInterface;
use App\Models\Feedback;

class RatingSurvey implements SurveyInterface
{
    public function renderForm(int $clientId): string
    {
        $clientId = (int) $clientId;
        $form = <<<HTML
<form method="POST" style="font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
    <h2>Оцените качество обслуживания</h2>
    <div style="margin: 20px 0;">
HTML;

        // кнопки 1–5
        for ($i = 1; $i <= 5; $i++) {
            $form .= "<button type=\"submit\" name=\"rating\" value=\"$i\" style=\"padding: 10px 20px; margin: 5px; font-size: 16px; background: #f0f0f0; border: 1px solid #ccc; border-radius: 4px; cursor: pointer;\">$i</button>\n";
        }

        $form .= <<<HTML
    </div>
    <label for="comment">При желании оставьте комментарий к отзыву:</label><br>
    <textarea name="comment" id="comment" rows="3" style="width: 100%; margin-top: 10px; padding: 8px; border: 1px solid #ccc; border-radius: 4px;"></textarea>
    <input type="hidden" name="client_id" value="$clientId">
</form>
HTML;

        return $form;
    }

    public function handleSubmission(array $data): bool
    {
        if (!isset($data['client_id'], $data['rating'])) {
            return false;
        }

        $clientId = (int) $data['client_id'];
        $rating = (int) $data['rating'];
        $comment = $data['comment'] ?? null;

        // client_id должен быть > 0
        if ($clientId <= 0) {
            return false;
        }

        try {
            return Feedback::save($clientId, $rating, $comment);
        } catch (\InvalidArgumentException $e) {
            // если невалидный rating, то не сохраняем
            return false;
        }
    }
}