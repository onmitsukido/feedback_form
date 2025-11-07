<?php

namespace App\Interfaces;

interface SurveyInterface
{

    public function renderForm(int $clientId): string;

    
    public function handleSubmission(array $data): bool;
}