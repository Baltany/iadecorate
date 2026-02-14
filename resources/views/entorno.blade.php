@extends('layouts.customer')

@section('title', 'Entorno Interactivo 3D - IA Decorate')

@push('styles')
<style>
    .interactive-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      width: 100%;
      flex: 1;
      align-items: stretch;
    }

    .upload-section {
      display: flex;
      flex-direction: row;
      gap: 20px;
      justify-content: flex-start;
      align-items: center;
      padding: 40px;
    }

    .upload-text {
      font-size: 16px;
      color: var(--text-dark);
      font-weight: 500;
      white-space: nowrap;
    }

    .upload-button {
      padding: 12px 30px;
      background-color: #999999;
      color: var(--text-dark);
      border: none;
      border-radius: var(--input-radius);
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
      flex-shrink: 0;
    }

    .upload-button:hover {
      background-color: #888888;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .viewer-3d {
      background-color: #999999;
      border-radius: 12px;
      width: 100%;
      height: 90%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      color: var(--text-dark);
      font-weight: 600;
      margin: 40px 40px 40px 0;
    }

    @media (max-width: 1024px) {
      .interactive-container {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .viewer-3d {
        margin: 0 40px 0 40px;
      }
    }

    @media (max-width: 768px) {
      .interactive-container {
        gap: 20px;
      }

      .upload-section {
        gap: 15px;
        padding: 30px;
      }

      .upload-text {
        font-size: 14px;
      }

      .upload-button {
        padding: 10px 25px;
        font-size: 13px;
      }

      .viewer-3d {
        margin: 0 30px 0 30px;
      }
    }

    @media (max-width: 576px) {
      .interactive-container {
        gap: 15px;
      }

      .upload-section {
        gap: 10px;
        flex-wrap: wrap;
        padding: 20px;
      }

      .upload-text {
        font-size: 13px;
      }

      .upload-button {
        padding: 10px 20px;
        font-size: 12px;
      }

      .viewer-3d {
        font-size: 14px;
        margin: 0 20px 0 20px;
      }
    }
</style>
@endpush

@section('content')
<main class="main-content">
    <div class="interactive-container">
      <!-- Sección de Carga -->
      <div class="upload-section">
        <div class="upload-text">Seleccione un archivo</div>
        <button class="upload-button" onclick="document.getElementById('fileInput').click()">Añadir</button>
        <input type="file" id="fileInput" style="display: none;" accept=".obj,.fbx,.gltf,.glb">
      </div>

      <!-- Visor 3D -->
      <div class="viewer-3d">
        3D
      </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    // Funcionalidad de carga de archivos
    const fileInput = document.getElementById('fileInput');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            console.log('Archivo seleccionado:', file.name);
            // Aquí puedes agregar la lógica para procesar el archivo 3D
            // Por ejemplo, usar Three.js para renderizar el modelo
        }
    });
</script>
@endpush
