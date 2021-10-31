<?php

namespace App\Console\Commands;


use App\Paquete;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VerifyBenefitDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'benefit:check_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the date from a Benefit in a package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $paquetes = Paquete::all();
        $today_date = Carbon::now()->toDateString();
        foreach ($paquetes as $paquete) {
            if ($paquete->benefit != NULL and $paquete->benefit->validity < $today_date) {
                DB::beginTransaction();
                try {
                    $paquete->benefit_id = NULL;
                    $paquete->save();
                    DB::commit();
                } catch (\Exception $e) {
                    error_log('Something go wrong');
                    DB::rollBack();
                }
            }
        }
        $out->writeln("Benefits updated");
    }
}
