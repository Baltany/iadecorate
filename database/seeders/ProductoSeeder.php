<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            [
                'nombre' => 'Sofá Cheslón Moderno',
                'descripcion' => 'Sofá de diseño contemporáneo que combina confort y elegancia. Fabricado con materiales de alta calidad, es perfecto para cualquier espacio moderno. Sus líneas limpias y su estructura robusta lo hacen ideal para salas de estar, oficinas o espacios comerciales.',
                'precio' => 899.99,
                'stock' => 15,
                'imagen' => 'img/productos/sofa-cheslon.png',
            ],
            [
                'nombre' => 'Mesa de Centro Minimalista',
                'descripcion' => 'Mesa de centro con diseño minimalista y acabados en madera natural. Perfecta para complementar tu sala de estar con un toque de elegancia y funcionalidad.',
                'precio' => 249.99,
                'stock' => 25,
                'imagen' => 'img/productos/mesa-centro.png',
            ],
            [
                'nombre' => 'Lámpara de Pie Industrial',
                'descripcion' => 'Lámpara de pie con estilo industrial, ideal para iluminar cualquier rincón de tu hogar. Fabricada con materiales resistentes y duraderos.',
                'precio' => 129.99,
                'stock' => 30,
                'imagen' => 'img/productos/lampara-pie.png',
            ],
            [
                'nombre' => 'Silla Escandinava',
                'descripcion' => 'Silla con diseño escandinavo, cómoda y elegante. Perfecta para comedores, oficinas o espacios de trabajo. Disponible en varios colores.',
                'precio' => 89.99,
                'stock' => 50,
                'imagen' => 'img/productos/silla-escandinava.png',
            ],
            [
                'nombre' => 'Estantería Moderna',
                'descripcion' => 'Estantería con diseño moderno y múltiples compartimentos. Ideal para organizar libros, decoración y objetos personales con estilo.',
                'precio' => 189.99,
                'stock' => 20,
                'imagen' => 'img/productos/estanteria-moderna.png',
            ],
            [
                'nombre' => 'Alfombra Geométrica',
                'descripcion' => 'Alfombra con diseño geométrico contemporáneo. Perfecta para añadir calidez y estilo a cualquier habitación. Fácil de limpiar y mantener.',
                'precio' => 149.99,
                'stock' => 40,
                'imagen' => 'img/productos/alfombra-geometrica.png',
            ],
            [
                'nombre' => 'Cojines Decorativos Set',
                'descripcion' => 'Set de 4 cojines decorativos con diseños modernos. Ideales para dar un toque de color y confort a tu sofá o cama.',
                'precio' => 49.99,
                'stock' => 100,
                'imagen' => 'img/productos/cojines-decorativos.png',
            ],
            [
                'nombre' => 'Espejo de Pared Grande',
                'descripcion' => 'Espejo de pared con marco moderno. Perfecto para ampliar visualmente cualquier espacio y añadir un toque de elegancia.',
                'precio' => 179.99,
                'stock' => 18,
                'imagen' => 'img/productos/espejo-pared.png',
            ],
        ];

        foreach ($productos as $producto) {
            \App\Models\Producto::create($producto);
        }
    }
}
