<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class GenerateLibraryReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function handle()
    {
        // Example: Fetch issued books between two dates
        $issuedBooks = DB::table('issued_books')
            ->whereBetween('issue_date', [$this->startDate, $this->endDate])
            ->get();

        // Generate HTML for report
        $html = view('report_pdf', [
            'issuedBooks' => $issuedBooks,
            'start' => $this->startDate,
            'end' => $this->endDate,
        ])->render();

        // Generate PDF file
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);

        $fileName = 'library_report_' . now()->format('Ymd_His') . '.pdf';
        Storage::put('reports/' . $fileName, $pdf->output());

        \Log::info("Report generated: storage/app/reports/{$fileName}");
    }
}
