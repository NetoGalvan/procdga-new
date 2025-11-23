<?php

namespace App\Jobs\p08_solicita_servicios;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\p08_solicita_servicios\P08SolicitaServicio;
use App\Mail\p08_solicita_servicios\MailSolicitaServicioSolicitada;
use Illuminate\Support\Facades\Mail;

class JobSolicitaServicioSolicitada implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $solicitaServicio;
    protected $correos;
    protected $judCorreo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($solicitaServicio, $correos, $judCorreo)
    {
        $this->solicitaServicio = $solicitaServicio;
        $this->correos = $correos;
        $this->judCorreo = $judCorreo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       Mail::to($this->judCorreo)
            ->cc($this->correos)
            ->send(new MailSolicitaServicioSolicitada($this->solicitaServicio));
    }
}
