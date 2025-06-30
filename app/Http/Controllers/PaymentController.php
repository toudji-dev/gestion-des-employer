<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Employer;
use App\Models\Payment;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;



class PaymentController extends Controller

{

    public  function __construct()
    {
        $this->middleware('permission:payment')->only('index');
        $this->middleware('permission:payment-lancer')->only('initPayment');
        $this->middleware('permission:payment-download')->only('download');
    }

    public function index()
    {

        $defaultPaymentDateQuery = Configuration::where('type', 'PAYMENT_DATE')->first();
        $defaultPaymentDate = $defaultPaymentDateQuery->value;
        $convertedPaymentDate = intval($defaultPaymentDate);
        $today = date('d');

        $isPaymentDay = false;

        if ($today == $convertedPaymentDate) {
            $isPaymentDay = true;
        }

        $payments = Payment::latest()->orderBy('id', 'desc')->simplePaginate(10);

        return view('paiements.index', compact('payments', 'isPaymentDay'));
    }



    public function initPayment()
    {
        $monthMapping = [
            '1' => 'JANVIER',
            '2' => 'FEVRIER',
            '3' => 'MARS',
            '4' => 'AVRIL',
            '5' => 'MAI',
            '6' => 'JUIN',
            '7' => 'JUILLET',
            '8' => 'AOUT',
            '9' => 'SEPTEMBRE',
            '10' => 'OCTOBRE',
            '11' => 'NOVEMBRE',
            '12' => 'DECEMENBRE'
        ];

        $currentMonth = strtoupper(Carbon::now()->month);

        // dd($currentMonth);

        //Mois en cour en francais
        $currentMonthInFrench = $monthMapping[$currentMonth] ?? '';

        //dd($currentMonthInFrench);
        //Année en cour

        $currentYear = Carbon::now()->format('Y');


        //Simuler des paiements pour tous les employers dans le mois en cour. Les paiement concerne les employer qui n'ont pas encore été payé dans le mois actuel.


        //Recuperer la liste des employer qui n'ont pas encore été payé pour le mois en cour.

        $employers = Employer::whereDoesntHave('payments', function ($query) use ($currentMonthInFrench, $currentYear) {

            $query->where('month', '=', $currentMonthInFrench)
                ->where('year', '=', $currentYear);
        })->get();

        if ($employers->count() === 0) {
            return redirect()->back()->with('error_message', 'Tous vos employer ont été payés pour ce mois ' . $currentMonthInFrench);
        }
        //Faire les paiement pour ces employers

        foreach ($employers as $employer) {

            $aEtePayer =  $employer->payments()->where('month', '=', $currentMonthInFrench)->where('year', '=', $currentYear)->exists();

            if (!$aEtePayer) {
                $salaire = $employer->montant_journalier * 31;

                $payment = new Payment([
                    'reference' => strtoupper(Str::random(10)),
                    'employer_id' => $employer->id,
                    'amount' => $salaire,
                    'launch_date' => now(),
                    'done_time' => now(),
                    'status' => 'SUCCESS',
                    'month' => $currentMonthInFrench,
                    'year' => $currentYear
                ]);

                $payment->save();
            }
        }

        //Rediriger

        return redirect()->back()->with('success_message', 'Paiement des employers effectuer pour le mois de ' . $currentMonthInFrench);
    }

    public function download(Payment $payment)
    {
        try {

            $fullPaymentInfo = Payment::with('employer')->find($payment->id);
            //return view('facture', compact('fullPaymentInfo'));
            $pdf = Pdf::loadView('facture', compact('fullPaymentInfo'));
            return $pdf->download('facture.pdf');
        } catch (Exception $e) {
            dd($e);
        }
    }
}