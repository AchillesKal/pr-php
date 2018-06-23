<?php declare(strict_types=1);

namespace PrPHP\FrontPage\Infrastructure;

use PrPHP\FrontPage\Application\Submission;
use PrPHP\FrontPage\Application\SubmissionsQuery;

final class MockSubmissionsQuery implements SubmissionsQuery
{
    private $submissions;
    public function __construct()
    {
        $this->submissions = [
            new Submission('https://duckduckgo.com', 'DuckDuckGo'),
            new Submission('https://google.com', 'Google'),
            new Submission('https://bing.com', 'Bing'),
        ];
    }
    public function execute(): array
    {
        return $this->submissions;
    }
}