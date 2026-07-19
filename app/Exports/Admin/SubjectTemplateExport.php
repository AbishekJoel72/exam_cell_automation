<?php

namespace App\Exports\Admin;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubjectTemplateExport implements FromArray
{
  protected $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
    public function array(): array
    {
        return [
            $this->fields,
        ];
    }
}
