<?php declare(strict_types=1);

namespace PrPHP\Submission\Domain;

interface SubmissionRepository
{
    public function add(Submission $submission): void;
}