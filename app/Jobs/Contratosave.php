<?php

namespace App\Jobs;

use App\Mail\EmailProject;
use App\Models\Contratos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;



class Contratosave implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $contrato;
    public function __construct(array $Contrato)
    {
        $this->contrato = $Contrato;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->contrato['documento'] = preg_replace("/[^0-9]/", "", $this->contrato['documento']);

         Contratos::create($this->contrato)->id;
        
    }
}
