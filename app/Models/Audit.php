<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use OwenIt\Auditing\Models\Audit as OwenAudit;

class Audit extends OwenAudit
{
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'auditable_type_formatted',
        'auditable_text_id',
        'auditable_route',
        'summary',
        'browser',
        'os',
        'device',
        'created_at_formatted',
    ];
    
    protected $perPage = 10;

    private Agent $agentParser;

    public function __construct()
    {
        $this->agentParser = new Agent();
        $this->agentParser->setUserAgent($this->user_agent);
    }

    /* accessors */

    protected function auditableTypeFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => Arr::last(explode('\\', $this->auditable_type))
        );
    }

    protected function auditableTextId(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->auditable_type) {
                User::class => $this->auditable?->name ?? 'Deleted User',
                default => $this->auditable_id,
            }
        );
    }

    public function auditableRoute(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::plural(strtolower($this->auditableTypeFormatted))
        );
    }

    protected function summary(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->user->name} {$this->event} " . strtolower($this->auditable_type_formatted) . " {$this->auditable_text_id}"
        );
    }

    protected function browser(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->agentParser->browser()
        );
    }

    protected function os(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->agentParser->platform()
        );
    }

    protected function device(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->agentParser->isDesktop() ? 'Desktop' : $this->agentParser->device()
        );
    }
    
    protected function createdAtFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->setTimezone('Asia/Manila')->format('M d Y, H:i:s')
        );
    }

    /* relationships */

    public function auditable()
    {
        return $this->morphTo()->withTrashed();
    }
}
