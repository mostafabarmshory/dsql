<?php

namespace atk4\dsql\Dumper;

use atk4\dsql\Expression;
use atk4\dsql\ProxyConnection;

class Connection extends ProxyConnection
{
    const DEFAULT_DRIVER_TYPE = 'dumper';

    /**
     * Callable to call for outputting.
     *
     * Will receive parameters:
     *  - Expression Expression object
     *  - float      How long it took to execute expression
     *  - boolean    True if we had exception while executing expression
     *
     * @var callable
     */
    public $callback;

    /**
     * @var float
     */
    protected $startTime;

    public static function createHandler(array $dsn)
    {
        return static::create($dsn['rest'], $dsn['user'], $dsn['pass']);
    }

    /**
     * Execute expression.
     *
     * @return \PDOStatement
     */
    public function execute(Expression $expr)
    {
        $this->startTime = microtime(true);

        try {
            $ret = parent::execute($expr);

            $this->dump($expr);
        } catch (\Exception $e) {
            $this->dump($expr, true);

            throw $e;
        }

        return $ret;
    }

    protected function dump(Expression $expr, $error = false)
    {
        $error = $error ? 'ERROR' : '';

        $took = microtime(true) - $this->startTime;

        if ($this->callback && is_callable($this->callback)) {
            call_user_func($this->callback, $expr, $took, false);
        } else {
            printf("[{$error} %02.6f] %s\n", $took, $expr->getDebugQuery());
        }
    }
}