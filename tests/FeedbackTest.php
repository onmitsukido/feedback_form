<?php

namespace Tests;

use App\Models\Feedback;
use PHPUnit\Framework\TestCase;

class FeedbackTest extends TestCase
{
    public function testSaveValidFeedback(): void
    {
        $result = Feedback::save(123, 4, "Хорошо");
        $this->assertTrue($result);
    }

    public function testSaveFeedbackWithoutComment(): void
    {
        $result = Feedback::save(123, 2);
        $this->assertTrue($result);
    }

    public function testSaveThrowsExceptionOnInvalidRating(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rating must be between 1 and 5.');

        Feedback::save(123, 6, "Невалидная оценка");
    }
}