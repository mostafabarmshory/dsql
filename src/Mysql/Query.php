<?php

declare(strict_types=1);

namespace Atk4\Dsql\Mysql;

use Atk4\Dsql\Query as BaseQuery;

class Query extends BaseQuery
{
    protected $escape_char = '`';

    protected $expression_class = Expression::class;

    protected $template_update = 'update [table][join] set [set] [where]';

    public function groupConcat($field, string $delimiter = ',')
    {
        return $this->expr('group_concat({} separator [])', [$field, $delimiter]);
    }
}
