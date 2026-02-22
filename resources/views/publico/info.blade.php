@extends('layouts.customer')

@section('title', 'Información - IA Decorate')

@push('styles')
<style>
    .info-main-content {
      flex: 1;
      overflow-y: auto;
      padding: 40px;
      background-color: #f5f5f5;
    }

    .info-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      align-items: center;
      margin-bottom: 60px;
    }

    .section.text-only {
      grid-template-columns: 1fr;
    }

    .section-image {
      width: 100%;
      aspect-ratio: 1 / 1;
      background-color: #d0d0d0;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 600;
      color: var(--text-dark);
      font-size: 18px;
      text-align: center;
      padding: 20px;
    }

    .section-content {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .section-title {
      font-size: 28px;
      font-weight: 900;
      color: var(--text-dark);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .section-text {
      font-size: 14px;
      color: var(--text-dark);
      line-height: 1.7;
      text-align: justify;
    }

    .image-holder-text {
      writing-mode: vertical-rl;
      transform: rotate(180deg);
      font-weight: 900;
      font-size: 24px;
      color: var(--text-dark);
      letter-spacing: 2px;
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
      .info-main-content {
        padding: 30px;
      }

      .section {
        grid-template-columns: 1fr;
        gap: 30px;
        margin-bottom: 40px;
      }

      .section.text-only {
        grid-template-columns: 1fr;
      }

      .section-title {
        font-size: 24px;
      }

      .section-text {
        font-size: 13px;
      }
    }

    @media (max-width: 768px) {
      .info-main-content {
        padding: 20px 15px;
      }

      .section {
        gap: 20px;
        margin-bottom: 30px;
      }

      .info-container {
        max-width: 100%;
      }

      .section-title {
        font-size: 20px;
      }

      .section-text {
        font-size: 12px;
      }

      .section-image {
        font-size: 16px;
      }
    }

    @media (max-width: 576px) {
      .info-main-content {
        padding: 15px 10px;
      }

      .section {
        gap: 15px;
        margin-bottom: 25px;
      }

      .section-title {
        font-size: 18px;
      }

      .section-text {
        font-size: 11px;
      }

      .section-image {
        font-size: 14px;
        padding: 15px;
      }
    }
</style>
@endpush

@section('content')
<main class="info-main-content">
    <div class="info-container">
      <!-- SECCIÓN 1: ¿QUIÉNES SOMOS? -->
      <div class="section">
        <div class="section-image">
          <span class="image-holder-text">HOLDER DE IMAGEN</span>
        </div>
        <div class="section-content">
          <h2 class="section-title">¿Quiénes somos?</h2>
          <p class="section-text">
            IA Decorate es tu tienda online especializada en decoración y mobiliario para el hogar.
            Ofrecemos productos de alta calidad con diseños modernos y funcionales. Nacimos con la
            visión de transformar la experiencia de decoración mediante la tecnología de visualización
            3D, permitiendo a nuestros clientes ver exactamente cómo quedarán los productos en sus
            espacios antes de comprar. Nuestro equipo está formado por profesionales apasionados por
            el diseño interior y la innovación tecnológica, comprometidos con ofrecer la mejor
            experiencia de compra posible.
          </p>
        </div>
      </div>

      <!-- SECCIÓN 2: CASOS REALES (SOLO TEXTO) -->
      <div class="section text-only">
        <div class="section-content">
          <h2 class="section-title">Casos Reales</h2>
          <p class="section-text">
            Nuestros clientes han transformado sus hogares con nuestros productos. Desde pequeños
            apartamentos urbanos hasta amplias casas familiares, cada proyecto es único y especial.
            Hemos ayudado a decorar espacios de trabajo modernos, dormitorios acogedores, salones
            elegantes y cocinas funcionales. La satisfacción de nuestros clientes es nuestra mayor
            recompensa, y sus historias de éxito nos motivan a seguir mejorando día a día. Cada
            producto que ofrecemos ha sido cuidadosamente seleccionado pensando en la calidad,
            durabilidad y estilo.
          </p>
        </div>
      </div>

      <!-- SECCIÓN 3: ¿DÓNDE OBTENEMOS NUESTRAS CLAVES? -->
      <div class="section">
        <div class="section-image">
          <span class="image-holder-text">HOLDER DE IMAGEN</span>
        </div>
        <div class="section-content">
          <h2 class="section-title">¿Dónde obtenemos nuestras claves?</h2>
          <p class="section-text">
            Trabajamos directamente con fabricantes y diseñadores de renombre internacional para
            garantizar la autenticidad y calidad de cada pieza. Nuestras relaciones de larga data
            con proveedores de confianza nos permiten ofrecer productos exclusivos a precios
            competitivos. Visitamos ferias internacionales de mobiliario y diseño para estar
            siempre a la vanguardia de las últimas tendencias. Además, contamos con un riguroso
            proceso de control de calidad que asegura que cada producto cumpla con nuestros
            estándares antes de llegar a tu hogar.
          </p>
        </div>
      </div>

      <!-- SECCIÓN 4: NUESTRO OBJETIVO (SOLO TEXTO) -->
      <div class="section text-only">
        <div class="section-content">
          <h2 class="section-title">Nuestro objetivo: que el cliente esté contento con el resultado</h2>
          <p class="section-text">
            La satisfacción del cliente es el corazón de nuestro negocio. Nos esforzamos por
            proporcionar no solo productos excepcionales, sino también un servicio al cliente
            incomparable. Nuestro equipo de soporte está disponible para ayudarte en cada paso
            del proceso, desde la selección del producto hasta la entrega e instalación. Ofrecemos
            garantías completas en todos nuestros productos y una política de devolución flexible.
            Tu hogar es tu santuario, y queremos que cada compra que hagas con nosotros contribuya
            a crear el espacio perfecto donde te sientas cómodo, inspirado y feliz.
          </p>
        </div>
      </div>

      <!-- SECCIÓN 5: CONTACTO -->
      <div class="section text-only">
        <div class="section-content">
          <h2 class="section-title">Contáctanos</h2>
          <p class="section-text">
            <i class="fas fa-envelope"></i> <strong>Email:</strong> info@iadecorate.com<br><br>
            <i class="fas fa-phone"></i> <strong>Teléfono:</strong> +34 900 123 456<br><br>
            <i class="fas fa-map-marker-alt"></i> <strong>Dirección:</strong> Calle Principal 123, Madrid, España<br><br>
            <i class="fas fa-clock"></i> <strong>Horario:</strong> Lunes a Viernes: 9:00 - 18:00h | Sábados: 10:00 - 14:00h
          </p>
        </div>
      </div>
    </div>
</main>
@endsection
