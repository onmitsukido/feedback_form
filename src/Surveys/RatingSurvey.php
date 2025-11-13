<?php
namespace App\Surveys;
use App\Interfaces\SurveyInterface;
use App\Models\Feedback;

class RatingSurvey implements SurveyInterface
{
    public function renderForm(int $clientId): string
    {
        $clientId = (int) $clientId;
        $form = '<div class="feedback-container">
                    <h2 class="feedback-title">Оцените качество обслуживания</h2>
                    <form method="POST">
                        <div class="rating-grid">';
        // Кнопки 1–5 в гриде
        for ($i = 1; $i <= 5; $i++) {
            $form .= '<button type="submit" name="rating" value="' . $i . '" class="rating-btn">' . $i . '</button>';
        }
        $form .= '      </div>
                        <label for="comment" class="comment-label">При желании оставьте комментарий к отзыву:</label>
                        <textarea name="comment" id="comment" rows="3" class="comment-textarea"></textarea>
                        <input type="hidden" name="client_id" value="' . $clientId . '">
                        <button type="submit" class="submit-btn">Отправить отзыв (пока не работает)</button>
                    </form>
                </div>';

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