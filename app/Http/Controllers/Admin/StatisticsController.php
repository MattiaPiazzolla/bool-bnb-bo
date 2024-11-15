<?php
namespace App\Http\Controllers\Admin;

use App\Models\RealEstate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Mostra un riepilogo delle statistiche per tutti gli immobili dell'utente.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $real_estates = RealEstate::where('user_id', Auth::id())
            ->with(['views', 'messages'])
            ->get();
    
        // Calcolare le statistiche delle visite per mese
        $monthlyViews = collect();
        $monthlyMessages = collect();  // Aggiungi questa variabile per i messaggi mensili
        $messageCounts = [];
        $statistics = [];
        $barChartData = [];
    
        // Trova l'immobile con più successo in base alle visite
        $maxViews = 0;
        $topRealEstate = null;
    
        foreach ($real_estates as $real_estate) {
            // Calcoliamo le statistiche per le visite mensili
            foreach ($real_estate->views as $view) {
                $month = Carbon::parse($view->created_at)->format('Y-m');
                $monthlyViews->put($month, $monthlyViews->get($month, 0) + 1);
            }
    
            // Calcoliamo le statistiche per i messaggi mensili
            foreach ($real_estate->messages as $message) {
                $month = Carbon::parse($message->created_at)->format('Y-m');
                $monthlyMessages->put($month, $monthlyMessages->get($month, 0) + 1);
            }
    
            // Contiamo i messaggi per immobile
            $messageCounts[$real_estate->title] = $real_estate->messages->count();
    
            // Calcoliamo le statistiche generali
            $statistics[] = [
                'id' => $real_estate->id,
                'title' => $real_estate->title,
                'views' => $real_estate->views->count(),
                'messages' => $real_estate->messages->count(),
                'active_subscriptions' => $real_estate->subscriptions->count(),
            ];
    
            // Dati per il grafico orizzontale
            $barChartData[$real_estate->title] = $real_estate->views->count();
    
            // Trova l'immobile con il maggior numero di visite
            if ($real_estate->views->count() > $maxViews) {
                $maxViews = $real_estate->views->count();
                $topRealEstate = $real_estate;
            }
        }
    
        // Ordina le visite mensili per mese
        $monthlyViews = $monthlyViews->sortKeys();
        $monthlyMessages = $monthlyMessages->sortKeys();  // Ordina i messaggi mensili
    
        // Formattiamo i mesi in formato leggibile
        $formattedMonths = $monthlyViews->keys()->map(function($month) {
            return Carbon::parse($month)->locale('it')->isoFormat('MMM');
        });
    
        // Passiamo tutte le variabili alla vista
        return view('statistics.index', [
            'statistics' => $statistics,
            'monthlyViews' => $monthlyViews,
            'monthlyMessages' => $monthlyMessages,  // Passa i messaggi mensili alla vista
            'formattedMonths' => $formattedMonths,
            'pieChartLabels' => array_keys($messageCounts),
            'pieChartData' => array_values($messageCounts),
            'barChartData' => $barChartData,
            'topRealEstate' => $topRealEstate,  // Passiamo l'immobile con il massimo numero di visite
        ]);
    }
}