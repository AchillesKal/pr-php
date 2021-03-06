<?php declare(strict_types=1);

namespace PrPHP\FrontPage\Infrastructure;

use Doctrine\DBAL\Connection;

use PrPHP\FrontPage\Application\Submission;
use PrPHP\FrontPage\Application\SubmissionsQuery;

final class DbalSubmissionsQuery implements SubmissionsQuery
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->addSelect('title');
        $qb->addSelect('url');
        $qb->from('submissions');
        $qb->orderBy('creation_date', 'DESC');
        $stmt = $qb->execute();
        $rows = $stmt->fetchAll();
        $submissions = [];
        foreach ($rows as $row) {
            $submissions[] = new Submission($row['url'], $row['title']);
        }
        return $submissions;
    }
}
