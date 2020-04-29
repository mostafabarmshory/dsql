<?php

namespace atk4\dsql\Oracle\Version12c;

use atk4\dsql\Oracle\Connection as BaseConnection;

/**
 * Custom Connection class specifically for Oracle 12c database.
 */
class Connection extends BaseConnection
{
    const DEFAULT_DRIVER_TYPE = 'oci12';

    /** @var string Query classname */
    protected $queryClass = Query::class;

    public static function createHandler(array $dsn)
    {
        $dsn['dsn'] = str_replace('oci12:', 'oci:', $dsn['dsn']);

        return parent::createHandler($dsn);
    }
}