<?php

namespace App\Datatable;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DatatablePaginator implements \JsonSerializable
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;
    /**
     * @var int
     */
    private $draw;

    public function __construct(LengthAwarePaginator $paginator, $draw = 1)
    {
        $this->paginator = $paginator;
        $this->draw = $draw;
    }


    public function toArray()
    {
        return [
            'draw' => (int)$this->draw,
            'recordsTotal' => $this->paginator->total(),
            'recordsFiltered' => $this->paginator->total(),
            'data' => $this->paginator->items()
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
