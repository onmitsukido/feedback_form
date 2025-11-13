<?php
namespace App\Controllers;
use App\Models\Client;
use App\Surveys\RatingSurvey;

class FeedbackController
{
    private RatingSurvey $survey;

    public function __construct()
    {
        $this->survey = new RatingSurvey();
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $clientId = filter_input(INPUT_GET, 'client_id', FILTER_VALIDATE_INT);

        if ($clientId === false || $clientId === null || !Client::exists($clientId)) {
            $this->showUnavailableMessage();
            return;
        }

        if ($method === 'POST') {
            $this->handlePost($clientId);
        } else {
            $this->showForm($clientId);
        }
    }

    private function showForm(int $clientId): void
    {
        $cssLink = '<link rel="stylesheet" href="/assets/css/style.css">';

        echo '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Оставьте отзыв</title>
    ' . $cssLink . '
</head>
<body>
    ' . $this->survey->renderForm($clientId) . '
</body>
</html>';
    }

    private function handlePost(int $clientId): void
    {
        if ($this->survey->handleSubmission($_POST)) {
            $cssLink = '<link rel="stylesheet" href="/assets/css/style.css">';
            $jsScript = '<script src="/assets/js/script.js"></script>';

            echo '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Спасибо!</title>
    ' . $cssLink . '
</head>
<body style="font-family: Arial; text-align: center; margin-top: 50px;">
    <h2>Спасибо за ваш отзыв!</h2>
    <p>Ваше мнение очень важно для нас.</p>
    ' . $jsScript . '
</body>
</html>';
        } else {
            http_response_code(400);
            echo '<h2>Ошибка при отправке отзыва. Попробуйте снова.</h2>';
        }
    }

    private function showUnavailableMessage(): void
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ссылка недоступна</title>
</head>
<body style="font-family: Arial; padding: 40px; max-width: 600px; margin: 0 auto;">
        <h2>Ссылка на голосование недоступна</h2>
        <p>Свяжитесь с нами по телефону.</p>
    </body>
</html>';
    }
}