<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class SyncProductInventory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inventory:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincronizar todos los productos con el inventario, creando registros faltantes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sincronizando productos con inventario...');

        // Obtener todos los productos (incluyendo eliminados suavemente)
        $products = Product::withTrashed()->get();
        $created = 0;
        $existing = 0;
        $skipped = 0;

        foreach ($products as $product) {
            // Si el producto está eliminado suavemente, saltar
            if ($product->trashed()) {
                $this->line("⏭️  Omitido (eliminado): {$product->name}");
                $skipped++;
                continue;
            }

            // Verificar si ya existe un registro de inventario
            $inventoryExists = DB::table('inventory')
                ->where('product_id', $product->id)
                ->exists();

            if (!$inventoryExists) {
                // Crear registro de inventario con columnas básicas
                DB::table('inventory')->insert([
                    'product_id' => $product->id,
                    'current_stock' => 0,
                    'minimum_stock' => 5,
                    'maximum_stock' => 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->line("✅ Creado inventario para: {$product->name}");
                $created++;
            } else {
                $existing++;
            }
        }

        $this->newLine();
        $this->info("Sincronización completada:");
        $this->info("- Productos totales: {$products->count()}");
        $this->info("- Productos activos: " . ($products->count() - $skipped));
        $this->info("- Productos eliminados: {$skipped}");
        $this->info("- Inventarios creados: {$created}");
        $this->info("- Inventarios existentes: {$existing}");

        return Command::SUCCESS;
    }
}
