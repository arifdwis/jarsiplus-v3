<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $dumpPath = base_path('database_dump.sql');
        if (file_exists($dumpPath)) {
            $sql = file_get_contents($dumpPath);
            
            // Extract only CREATE TABLE statements to create clean schema
            preg_match_all('/CREATE TABLE [`"]([^`"]+)[`"].*?;/s', $sql, $matches);
            if (!empty($matches[0])) {
                foreach ($matches[0] as $createStmt) {
                    // Extract table name
                    if (preg_match('/CREATE TABLE [`"]([^`"]+)[`"]/', $createStmt, $tableMatch)) {
                        $tableName = $tableMatch[1];
                        if (!Schema::hasTable($tableName)) {
                            DB::unprepared($createStmt);
                        }
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $dumpPath = base_path('database_dump.sql');
        if (file_exists($dumpPath)) {
            $sql = file_get_contents($dumpPath);
            preg_match_all('/CREATE TABLE [`"]([^`"]+)[`"]/', $sql, $matches);
            if (!empty($matches[1])) {
                foreach ($matches[1] as $tableName) {
                    if ($tableName !== 'migrations') {
                        Schema::dropIfExists($tableName);
                    }
                }
            }
        }
    }
};
