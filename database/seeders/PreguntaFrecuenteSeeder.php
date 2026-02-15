<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreguntaFrecuente;

class PreguntaFrecuenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preguntas = [
            [
                'pregunta' => '¿Cómo puedo cargar una imagen en 3D?',
                'respuesta' => 'Para cargar una imagen 3D, ve a la sección "3D" en el menú, haz clic en "Seleccione un archivo" y después en "Añadir". Los formatos soportados son .obj, .fbx, .gltf y .glb.',
                'activa' => true,
                'orden' => 1,
            ],
            [
                'pregunta' => '¿Qué formatos de imagen son soportados?',
                'respuesta' => 'Los formatos de imagen soportados son: JPG, PNG, GIF y WEBP. Asegúrate de que tu archivo esté en uno de estos formatos antes de subirlo.',
                'activa' => true,
                'orden' => 2,
            ],
            [
                'pregunta' => '¿Cómo puedo rastrear mi pedido?',
                'respuesta' => 'Puedes rastrear tu pedido desde la sección "Mis Pedidos" en tu perfil. Allí encontrarás el estado actualizado de todos tus pedidos y el número de seguimiento.',
                'activa' => true,
                'orden' => 3,
            ],
            [
                'pregunta' => '¿Cuánto tiempo tarda el envío?',
                'respuesta' => 'El tiempo de envío varía según tu ubicación. Generalmente, los pedidos nacionales tardan entre 3-5 días hábiles, mientras que los internacionales pueden tardar entre 7-15 días hábiles.',
                'activa' => true,
                'orden' => 4,
            ],
            [
                'pregunta' => '¿Cómo puedo cambiar mi contraseña?',
                'respuesta' => 'Para cambiar tu contraseña, ve a tu perfil haciendo clic en el ícono de usuario, selecciona "Editar Perfil" y allí encontrarás la opción para cambiar tu contraseña.',
                'activa' => true,
                'orden' => 5,
            ],
            [
                'pregunta' => '¿Puedo cancelar mi pedido?',
                'respuesta' => 'Sí, puedes cancelar tu pedido siempre que no haya sido enviado aún. Contacta con nosotros lo antes posible a través de la mensajería interna o reporta una incidencia.',
                'activa' => true,
                'orden' => 6,
            ],
            [
                'pregunta' => '¿Cómo funcionan los pagos?',
                'respuesta' => 'Aceptamos varios métodos de pago incluyendo tarjetas de crédito/débito y PayPal. Todos los pagos son procesados de forma segura a través de nuestros proveedores certificados.',
                'activa' => true,
                'orden' => 7,
            ],
            [
                'pregunta' => '¿Qué hago si recibo un producto defectuoso?',
                'respuesta' => 'Si recibes un producto defectuoso, por favor contacta con nosotros inmediatamente a través de una incidencia. Te proporcionaremos un reemplazo o reembolso según corresponda.',
                'activa' => true,
                'orden' => 8,
            ],
        ];

        foreach ($preguntas as $pregunta) {
            PreguntaFrecuente::create($pregunta);
        }
    }
}
