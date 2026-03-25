<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ExportDatabaseSql extends Command
{
    protected $signature = 'db:export-sql
                            {--path=database/exports/resto_kwetu_dump.sql : Chemin du fichier .sql à générer}';

    protected $description = 'Exporte le schéma et les données MySQL/SQLite vers un fichier SQL structuré';

    public function handle(): int
    {
        $driver = DB::connection()->getDriverName();
        $path = base_path($this->option('path'));

        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $fh = fopen($path, 'wb');
        if ($fh === false) {
            $this->error('Impossible d\'écrire : '.$path);

            return self::FAILURE;
        }

        fwrite($fh, '-- Export Resto Kwetu — généré le '.date('c')."\n");
        fwrite($fh, "-- Driver : {$driver}\n\n");
        fwrite($fh, "SET NAMES utf8mb4;\n");
        fwrite($fh, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tables = $this->orderedTableNames($this->tableNames($driver));

        foreach ($tables as $table) {
            $this->line('Table : '.$table);
            $this->exportTable($fh, $driver, $table);
            fwrite($fh, "\n");
        }

        fwrite($fh, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($fh);

        $this->info('Fichier créé : '.$path);

        return self::SUCCESS;
    }

    /**
     * @return list<string>
     */
    private function tableNames(string $driver): array
    {
        if ($driver === 'sqlite') {
            $rows = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name");

            return array_map(fn ($r) => $r->name, $rows);
        }

        $rows = DB::select('SHOW TABLES');
        if ($rows === []) {
            return [];
        }

        $first = (array) $rows[0];
        $key = array_key_first($first);

        return array_map(fn ($r) => $r->{$key}, $rows);
    }

    /**
     * Ordre de création respectant les clés étrangères (évite l’erreur MySQL 150 en import).
     * Sans cela, SHOW TABLES (ordre alphabétique) place souvent medias_plats avant plats.
     *
     * @param  list<string>  $tables
     * @return list<string>
     */
    private function orderedTableNames(array $tables): array
    {
        $tables = array_values(array_unique($tables));

        $priorite = [
            'migrations',
            'users',
            'password_reset_tokens',
            'sessions',
            'cache',
            'cache_locks',
            'jobs',
            'job_batches',
            'failed_jobs',
            'personal_access_tokens',
            'categories',
            'restaurants',
            'plats',
            'medias_plats',
        ];

        $ordered = [];
        foreach ($priorite as $name) {
            if (in_array($name, $tables, true)) {
                $ordered[] = $name;
            }
        }

        $reste = array_values(array_diff($tables, $ordered));
        sort($reste, SORT_STRING);

        return array_merge($ordered, $reste);
    }

    private function exportTable($fh, string $driver, string $table): void
    {
        if ($driver === 'sqlite') {
            $create = DB::selectOne("SELECT sql FROM sqlite_master WHERE type='table' AND name = ?", [$table]);
            fwrite($fh, 'DROP TABLE IF EXISTS `'.$table."`;\n");
            fwrite($fh, $create->sql.";\n\n");
        } else {
            $row = DB::selectOne('SHOW CREATE TABLE `'.$table.'`');
            $createKey = 'Create Table';
            fwrite($fh, 'DROP TABLE IF EXISTS `'.$table."`;\n");
            fwrite($fh, $row->{$createKey}.";\n\n");
        }

        if (! Schema::hasTable($table)) {
            return;
        }

        $columns = Schema::getColumnListing($table);
        if ($columns === []) {
            return;
        }

        $quotedCols = array_map(fn (string $c) => '`'.str_replace('`', '``', $c).'`', $columns);

        DB::table($table)->orderBy($columns[0])->chunk(200, function ($rows) use ($fh, $table, $columns, $quotedCols): void {
            $valuesBlock = [];
            foreach ($rows as $row) {
                $vals = [];
                foreach ($columns as $col) {
                    $vals[] = $this->escapeSqlValue($row->{$col} ?? null);
                }
                $valuesBlock[] = '('.implode(', ', $vals).')';
            }
            $sql = 'INSERT INTO `'.str_replace('`', '``', $table).'` ('.implode(', ', $quotedCols).") VALUES\n"
                .implode(",\n", $valuesBlock).";\n";
            fwrite($fh, $sql);
        });
    }

    private function escapeSqlValue(mixed $value): string
    {
        if ($value === null) {
            return 'NULL';
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_int($value) || is_float($value)) {
            if (is_nan($value)) {
                return 'NULL';
            }

            return (string) $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return "'".$value->format('Y-m-d H:i:s')."'";
        }

        if (is_resource($value)) {
            return 'NULL';
        }

        $s = (string) $value;

        return "'".str_replace(
            ['\\', "'", "\x00", "\n", "\r", "\x1a"],
            ['\\\\', "\\'", '\\0', '\\n', '\\r', '\\Z'],
            $s
        )."'";
    }
}
