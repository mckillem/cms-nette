<?php
declare(strict_types=1);

namespace App\Models;

use Nette\Security\Passwords;
use Nette\Database\Table\Selection;
use Nette\SmartObject;
use Nette\Security\IAuthenticator;
use Nette\Security\IIdentity;
use Nette\Security\Identity;
use Nette\Security\AuthenticationException;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Database\Explorer;
use Nette\Utils\Validators;
use App\Forms\DuplicateNameException;

final class UserManager implements IAuthenticator
{
	use SmartObject;

	private const
		TABLE_NAME = 'user',
		COLUMN_ID = 'id',
		COLUMN_PASSWORD_HASH = 'password',
		COLUMN_EMAIL = 'email',
		COLUMN_FIRSTNAME = 'firstname',
		COLUMN_LASTNAME = 'lastname',
		COLUMN_ROLE = 'role';

	private Explorer $database;

	private Passwords $passwords;

	public function __construct(Explorer $database, Passwords $passwords)
	{
		$this->database = $database;
		$this->passwords = $passwords;
	}

	/**
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials): IIdentity
	{
		[$email, $password] = $credentials;

		$row = $this->database->table(self::TABLE_NAME)
			->where(self::COLUMN_EMAIL, $email)
			->fetch();
//todo: oprvadu je vhodné rozlišovat mezi heslem a emailem? Může zjednodušit nabourání do systému
		if (!$row) {
			throw new AuthenticationException('Zadali jste nesprávný email.', self::IDENTITY_NOT_FOUND);
		} elseif (!$this->passwords->verify($password, $row[self::COLUMN_PASSWORD_HASH])) {
			throw new AuthenticationException('Vaše heslo není správné.', self::INVALID_CREDENTIAL);
		} elseif ($this->passwords->needsRehash($row[self::COLUMN_PASSWORD_HASH])) {
			$row->update([
				self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
			]);
		}

		$arr = $row->toArray();
		unset($arr[self::COLUMN_PASSWORD_HASH]);

		return new Identity($row[self::COLUMN_ID], $row[self::COLUMN_ROLE], $arr);
	}

	public function add(string $firstname, string $lastname, string $email, string $password, string $role): void {
		Validators::assert($email, 'email');
		try {
			$this->database->table(self::TABLE_NAME)->insert([
				self::COLUMN_FIRSTNAME => $firstname,
				self::COLUMN_LASTNAME => $lastname,
				self::COLUMN_PASSWORD_HASH => $this->passwords->hash($password),
				self::COLUMN_EMAIL => $email,
				self::COLUMN_ROLE => $role,
			]);
		} catch (UniqueConstraintViolationException $e) {
			throw new DuplicateNameException;
		}
	}

	public function getUsers(): Selection {
		return $this->database->table(self::TABLE_NAME);
	}

	public function removeUser(int $id) {
		$this->database->table(self::TABLE_NAME)->where(self::COLUMN_ID, $id)->delete();
	}
}