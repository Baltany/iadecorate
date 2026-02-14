<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['Sofás', 'Mesas', 'Sillas', 'Lámparas', 'Estanterías', 'Decoración', 'Alfombras'];

        return [
            'nombre' => fake()->words(3, true) . ' ' . fake()->randomElement(['Moderno', 'Clásico', 'Minimalista', 'Industrial', 'Escandinavo']),
            'descripcion' => fake()->paragraph(3),
            'precio' => fake()->randomFloat(2, 29.99, 1999.99),
            'stock' => fake()->numberBetween(0, 100),
            'imagen' => 'image.png', // Se puede usar Faker para generar URLs de imágenes
            'categoria_id' => null, // O fake()->numberBetween(1, 5) si tienes categorías
        ];
    }
}
