<?php declare(strict_types=1);

namespace PrPHP\User\Presentation;

use PrPHP\Framework\Csrf\StoredTokenValidator;
use PrPHP\User\Application\RegisterUser;
use PrPHP\Framework\Csrf\Token;
use PrPHP\User\Application\NicknameTakenQuery;

final class RegisterUserForm
{

    private $storedTokenValidator;
    private $token;
    private $nickname;
    private $password;
    private $nicknameTakenQuery;

    public function __construct(
        StoredTokenValidator $storedTokenValidator,
        string $token,
        string $nickname,
        string $password,
        NicknameTakenQuery $nicknameTakenQuery
    ) {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->token = $token;
        $this->nickname = $nickname;
        $this->password = $password;
        $this->nicknameTakenQuery = $nicknameTakenQuery;
    }

    public function hasValidationErrors(): bool
    {
        return (count($this->getValidationErrors()) > 0);
    }

    /**
     * @return string[]
     */
    public function getValidationErrors(): array
    {
        $errors = [];

        if (!$this->storedTokenValidator->validate(
            'registration',
            new Token($this->token)
        )) {
            $errors[] = 'Invalid token';
        }

        if (strlen($this->nickname) < 3 || strlen($this->nickname) > 20) {
            $errors[] = 'Nickname must be between 3 and 20 characters';
        }
        if (!ctype_alnum($this->nickname)) {
            $errors[] = 'Nickname can only consist of letters and numbers';
        }
        if (strlen($this->password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        if ($this->nicknameTakenQuery->execute($this->nickname)) {
            $errors[] = 'This nickname is already being used';
        }

        return $errors;
    }

    public function toCommand(): RegisterUser
    {
        return new RegisterUser($this->nickname, $this->password);
    }
}