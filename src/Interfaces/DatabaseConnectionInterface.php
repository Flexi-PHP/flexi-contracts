<?php

declare(strict_types=1);

namespace Flexi\Contracts\Interfaces;

/**
 * Contract for Database Connection
 * Provides abstraction layer for database connections supporting multiple database engines.
 * Compatible with SQL databases (MySQL, PostgreSQL, SQLite, SQL Server, Oracle)
 * and NoSQL databases (MongoDB, Redis, etc.).
 */
interface DatabaseConnectionInterface
{
    /**
     * Establish connection to the database.
     *
     * @param array $config Connection configuration parameters
     * @return bool True if connection successful
     * @throws \RuntimeException If connection fails
     */
    public function connect(array $config): bool;

    /**
     * Close the database connection.
     *
     * @return void
     */
    public function disconnect(): void;

    /**
     * Check if connection is active.
     *
     * @return bool True if connected
     */
    public function isConnected(): bool;

    /**
     * Execute a query and return results.
     *
     * @param string $query The query to execute
     * @param array $params Query parameters for prepared statements
     * @return mixed Query results
     * @throws \RuntimeException If query execution fails
     */
    public function query(string $query, array $params = []);

    /**
     * Execute a command without returning results.
     *
     * @param string $command The command to execute
     * @param array $params Command parameters
     * @return int Number of affected rows/documents
     * @throws \RuntimeException If command execution fails
     */
    public function execute(string $command, array $params = []): int;

    /**
     * Begin a transaction.
     *
     * @return bool True if transaction started successfully
     */
    public function beginTransaction(): bool;

    /**
     * Commit the current transaction.
     *
     * @return bool True if commit successful
     */
    public function commit(): bool;

    /**
     * Rollback the current transaction.
     *
     * @return bool True if rollback successful
     */
    public function rollback(): bool;

    /**
     * Check if currently in a transaction.
     *
     * @return bool True if in transaction
     */
    public function inTransaction(): bool;

    /**
     * Prepare a statement for execution.
     *
     * @param string $query The query to prepare
     * @return mixed Prepared statement object
     * @throws \RuntimeException If preparation fails
     */
    public function prepare(string $query);

    /**
     * Get the last inserted ID.
     *
     * @param string|null $name Sequence name (for databases that require it)
     * @return string|int Last insert ID
     */
    public function lastInsertId(?string $name = null);

    /**
     * Get the underlying native connection object.
     *
     * @return mixed Native connection object (PDO, mysqli, MongoDB\Client, etc.)
     */
    public function getNativeConnection();

    /**
     * Get database connection information.
     *
     * @return array Connection info (driver, host, database, version, etc.)
     */
    public function getConnectionInfo(): array;

    /**
     * Ping the database to check if connection is alive.
     *
     * @return bool True if connection is alive
     */
    public function ping(): bool;
}
