<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Departement;
use App\Models\Employer;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class AppController extends Controller
{
    public function index()
    {
        $totalDepartements = Departement::all()->count();
        $totalEmployers = Employer::all()->count();
        $totalAdministrateurs = User::all()->count();



        $defaultPaymentDate = null;
        $paymentNotification = "";
        //  $appName = Configuration::where('type','APP_NAME')->first();
        //
        $currentDate = Carbon::now()->day;

        $defaultPaymentDateQuery = Configuration::where('type', 'PAYMENT_DATE')->first();


        //      // dd($defaultPaymentDateQuery);

        if ($defaultPaymentDateQuery) {
            $defaultPaymentDate = $defaultPaymentDateQuery->value;
            $convertedPaymentDate = intval($defaultPaymentDate);


            if ($currentDate < $convertedPaymentDate) {
                $paymentNotification = "Le paiement doit avoir lieu le " . $defaultPaymentDate . " de ce mois.";
            } elseif ($currentDate == $convertedPaymentDate) {
                $paymentNotification = "Le paiement doit être effectué aujourd'hui.";
            } else {
                $monthMapping = [
                    'January' => 'JANVIER',
                    'February' => 'FEVRIER',
                    'March' => 'MARS',
                    'April' => 'AVRIL',
                    'May' => 'MAI',
                    'June' => 'JUIN',
                    'July' => 'JUILLET',
                    'August' => 'AOUT',
                    'September' => 'SEPTEMBRE',
                    'October' => 'OCTOBRE',
                    'November ' => 'NOVEMBRE',
                    'December' => 'DECEMENBRE'
                ];

                $nextMonth = Carbon::now()->addMonth()->format('F');

                //prochaine Mois en francais
                $nextMonthInFrench = $monthMapping[$nextMonth] ?? '';


                $paymentNotification = "Le paiement doit avoir lieu le " . $defaultPaymentDate . " du mois de " . $nextMonthInFrench . ".";
            }
        }
        return view('dashboard', compact('totalDepartements', 'totalEmployers', 'totalAdministrateurs', 'paymentNotification'));
    }
}
