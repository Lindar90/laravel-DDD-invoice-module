<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Modules\Invoices\Infrastructure\Database\Seeders\DatabaseSeeder as InvoicesDatabaseSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     */
    public function run(): void
    {
        $this->call([
            InvoicesDatabaseSeeder::class,
        ]);
    }
}
