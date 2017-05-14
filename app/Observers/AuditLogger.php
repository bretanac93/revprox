<?php

namespace App\Observers;

use App\Audit;

trait AuditLogger
{
    public function log($data)
    {
    	Audit::create($data);
    }
}
