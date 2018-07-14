<?php declare(strict_types=1);

namespace PrPHP\Submission\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

final class Submission
{
    private$id;
    private$url;
    private$title;
    private$creationDate;

    private function __construct(
        UuidInterface $id,
        AuthorId $authorId,
        string $url,
        string $title,
        DateTimeImmutable $creationDate
    ) {
        $this->id = $id;
        $this->authorId = $authorId;
        $this->url = $url;
        $this->title = $title;
        $this->creationDate = $creationDate;
    }

    public static function submit(UuidInterface $authorId, string $url, string $title): Submission
    {
        return new Submission(
            Uuid::uuid4(),
            AuthorId::fromUuid($authorId),
            $url,
            $title,
            new DateTimeImmutable()
        );
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function getAuthorId(): AuthorId
    {
        return $this->authorId;
    }
}