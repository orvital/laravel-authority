<?php

namespace Orvital\Auth\Invites;

use Orvital\Auth\Invites\Contracts\CanBeInvited as CanBeInvitedContract;
use Orvital\Auth\Invites\Contracts\TokenRepository as TokenRepositoryContract;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DatabaseTokenRepository implements TokenRepositoryContract
{
    /**
     * The database connection instance.
     */
    protected ConnectionInterface $connection;

    /**
     * The Hasher implementation.
     */
    protected HasherContract $hasher;

    /**
     * The token database table.
     */
    protected string $table;

    /**
     * The hashing key.
     */
    protected string $hashKey;

    /**
     * The number of seconds a token should last.
     */
    protected int $expires;

    /**
     * Minimum number of seconds before re-redefining the token.
     */
    protected int $throttle;

    /**
     * Create a new token repository instance.
     *
     * @return void
     */
    public function __construct(ConnectionInterface $connection, HasherContract $hasher,
                                string $table, string $hashKey, int $expires = 60, int $throttle = 60)
    {
        $this->connection = $connection;
        $this->hasher = $hasher;
        $this->table = $table;
        $this->hashKey = $hashKey;
        $this->expires = $expires * 60;
        $this->throttle = $throttle;
    }

    /**
     * Create a new token record.
     */
    public function create(CanBeInvitedContract $user): string
    {
        $email = $user->getEmailForInvite();

        $this->deleteExisting($user);

        // We will create a new, random token for the user so that we can e-mail them
        // a safe invite link. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $token = $this->createNewToken();

        $this->getTable()->insert($this->getPayload($email, $token));

        return $token;
    }

    /**
     * Delete all existing reset tokens from the database.
     */
    protected function deleteExisting(CanBeInvitedContract $user): int
    {
        return $this->getTable()->where('email', $user->getEmailForInvite())->delete();
    }

    /**
     * Build the record payload for the table.
     */
    protected function getPayload(string $email, string $token): array
    {
        return [
            'id' => strtolower((string) Str::ulid()),
            'email' => $email,
            'token' => $this->hasher->make($token),
            'created_at' => new Carbon,
        ];
    }

    /**
     * Determine if a token record exists and is valid.
     */
    public function exists(CanBeInvitedContract $user, string $token): bool
    {
        $record = (array) $this->getTable()->where(
            'email', $user->getEmailForInvite()
        )->first();

        return $record &&
               ! $this->tokenExpired($record['created_at']) &&
                 $this->hasher->check($token, $record['token']);
    }

    /**
     * Determine if the token has expired.
     */
    protected function tokenExpired(string $createdAt): bool
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    /**
     * Determine if the given token was recently created.
     */
    public function recentlyCreatedToken(CanBeInvitedContract $user): bool
    {
        $record = (array) $this->getTable()->where(
            'email', $user->getEmailForInvite()
        )->first();

        return $record && $this->tokenRecentlyCreated($record['created_at']);
    }

    /**
     * Determine if the token was recently created.
     */
    protected function tokenRecentlyCreated(string $createdAt): bool
    {
        if ($this->throttle <= 0) {
            return false;
        }

        return Carbon::parse($createdAt)->addSeconds(
            $this->throttle
        )->isFuture();
    }

    /**
     * Delete all existing invites from the database.
     */
    public function delete(CanBeInvitedContract $user): void
    {
        $this->deleteExisting($user);
    }

    /**
     * Delete expired tokens.
     */
    public function deleteExpired(): void
    {
        $expiredAt = Carbon::now()->subSeconds($this->expires);

        $this->getTable()->where('created_at', '<', $expiredAt)->delete();
    }

    /**
     * Create a new token.
     */
    protected function createNewToken(): string
    {
        return hash_hmac('sha256', Str::random(40), $this->hashKey);
    }

    /**
     * Get the database connection instance.
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * Begin a new database query against the table.
     */
    protected function getTable(): Builder
    {
        return $this->connection->table($this->table);
    }

    /**
     * Get the hasher instance.
     */
    public function getHasher(): HasherContract
    {
        return $this->hasher;
    }
}
