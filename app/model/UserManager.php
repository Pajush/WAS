<?php

namespace App\Model;

use Nette;
use Nette\Security\Passwords;


/**
 * Users management.
 */
class UserManager implements Nette\Security\IAuthenticator
{
    use Nette\SmartObject;

    const
        TABLE_NAME = 'user',
        COLUMN_ID = 'id',
        COLUMN_NAME = 'username',
        COLUMN_PASSWORD_HASH = 'password',
        //COLUMN_EMAIL = 'email',
        COLUMN_ROLE = 'id_role';


    /** @var Nette\Database\Context */
    private $database;


    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }


    /**
     * Performs an authentication.
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials)
    {
        list($username, $password) = $credentials;

        $row = $this->database->table(self::TABLE_NAME)->where(self::COLUMN_NAME, $username)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Přihlašovací jméno nebylo nalezeno.', self::IDENTITY_NOT_FOUND);

        } elseif (!Passwords::verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
            throw new Nette\Security\AuthenticationException('Heslo je nesprávné.', self::INVALID_CREDENTIAL);

        } elseif (Passwords::needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
            $row->update([
                self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
            ]);
        } elseif ($row[self::COLUMN_ROLE] != 1) {
            throw new Nette\Security\AuthenticationException('Nemáte dostatečná oprávnění pro přihlášení.', self::INVALID_CREDENTIAL);
        }

        $arr = $row->toArray();
        unset($arr[self::COLUMN_PASSWORD_HASH]);
        return new Nette\Security\Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);

    }


    /**
     * Adds new user.
     * @throws DuplicateNameException
     */
    public function add($username, $role, $password)
    {
        try {
            $this->database->table(self::TABLE_NAME)->insert([
                self::COLUMN_NAME => $username,
                self::COLUMN_PASSWORD_HASH => Passwords::hash($password),
                self::COLUMN_ROLE => $role,
            ]);
        } catch (Nette\Database\UniqueConstraintViolationException $e) {
            throw new DuplicateNameException;
        }
    }
    /**
     * Modify existing user's password.
     */

    public function modify($username, $password)
    {
        $this->database->table(self::TABLE_NAME)->where([self::COLUMN_NAME => $username])->update([
            self::COLUMN_PASSWORD_HASH => Passwords::hash($password)
        ]);
    }
}



class DuplicateNameException extends \Exception
{}