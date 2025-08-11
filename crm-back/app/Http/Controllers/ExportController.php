<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Exception;

class ExportController extends Controller
{
    public function exportCsv()
    {
        $table = 'leads'; // Replace with your actual table name
        $columns = \Schema::getColumnListing($table); // Get column names from the DB schema
    
        $csvFileName = $table . '_headings_only.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$csvFileName\"",
        ];
    
        $callback = function () use ($columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns); // Just the headings
            fclose($handle);
        };
    
        return Response::stream($callback, 200, $headers);
}
public function importCsv(Request $request)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt',
    ]);

    $table = 'leads'; // Use your table name

    try {
        $file = fopen($request->file('csv_file'), 'r');
        if (!$file) {
            throw new Exception("Failed to open the file.");
        }

        $header = fgetcsv($file);
        if (!$header) {
            throw new Exception("CSV file is empty or header is missing.");
        }

        // Remove unwanted columns from header
        $excludedColumns = ['id','created_at', 'updated_at'];
        $filteredHeader = array_filter($header, fn($col) => !in_array($col, $excludedColumns));

        $rowNumber = 1;

        while (($row = fgetcsv($file)) !== false) {
            $rowNumber++;

            // Remove corresponding values for excluded columns
            $filteredRow = array_intersect_key($row, array_flip(array_keys($filteredHeader)));

            if (count($filteredRow) != count($filteredHeader)) {
                throw new Exception("Row $rowNumber does not match header column count.");
            }

            $data = array_combine(array_values($filteredHeader), array_values($filteredRow));

            // Check if the phone number already exists within the last 200 days
            if (isset($data['phone_number'])) {
                $existingLead = DB::table($table)
                    ->where('phone_number', $data['phone_number'])
                    ->where('created_at', '>=', now()->subDays(200))
                    ->exists();

                if ($existingLead) {
                    Log::warning("Duplicate phone number found in row $rowNumber: " . $data['phone_number']);
                    continue; // Skip this row if the phone number already exists
                }
            }

            try {
                DB::table($table)->insert($data);
            } catch (QueryException $qe) {
                Log::error("SQL Error on row $rowNumber: " . $qe->getMessage());
                throw new Exception("SQL Error on row $rowNumber: " . $qe->getMessage());
            }
        }

        fclose($file);
        return back()->with('success', 'CSV imported successfully!');
    } catch (Exception $e) {
        Log::error('CSV Import Failed: ' . $e->getMessage());
        return back()->withErrors(['csv_error' => 'Import failed: ' . $e->getMessage()]);
    }
}
}
