<?php

namespace App\Jobs;

use CyrildeWit\EloquentViewable\VisitorCookieRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $viewable;
    public $visitor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($viewable)
    {
        $this->viewable = $viewable;
        $this->visitor = (new VisitorCookieRepository)->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        view($this->viewable)
            ->overrideVisitor($this->visitor)
            ->record();
    }
}
