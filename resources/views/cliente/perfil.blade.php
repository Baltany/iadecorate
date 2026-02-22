@extends('layouts.customer')

@section('title', 'Mi Perfil - IA Decorate')

@push('styles')
<style>
    .profile-main-content {
      flex: 1;
      padding: 40px;
      overflow-y: auto;
    }

    .profile-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    .profile-title {
      grid-column: 1 / -1;
      font-size: 42px;
      font-weight: 900;
      color: var(--text-dark);
      margin-bottom: 30px;
    }

    .form-section {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-input {
      padding: 14px 20px;
      border: none;
      border-radius: var(--input-radius);
      background-color: var(--primary-color);
      color: var(--text-dark);
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .form-input::placeholder {
      color: var(--text-dark);
      opacity: 0.7;
    }

    .form-input:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(238, 208, 157, 0.5);
      background-color: #f9f5e6;
    }

    .avatar-section {
      display: flex;
      flex-direction: column;
      gap: 20px;
      justify-content: center;
      align-items: center;
    }

    .avatar-container {
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background-color: #999999;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s ease;
      font-weight: 600;
      color: var(--text-dark);
      font-size: 16px;
      text-align: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    .avatar-container:hover {
      background-color: #888888;
      transform: scale(1.05);
    }

    .avatar-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 50%;
    }

    .avatar-input {
      display: none;
    }

    .profile-buttons {
      grid-column: 1 / -1;
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }

    .btn-profile-save {
      flex: 1;
      padding: 14px 20px;
      background-color: var(--primary-color);
      color: var(--text-dark);
      border: none;
      border-radius: var(--input-radius);
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-profile-save:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-profile-cancel {
      flex: 1;
      padding: 14px 20px;
      background-color: #f0f0f0;
      color: var(--text-dark);
      border: 2px solid #e0e0e0;
      border-radius: var(--input-radius);
      font-weight: 700;
      font-size: 14px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-profile-cancel:hover {
      background-color: #e0e0e0;
      transform: translateY(-2px);
    }

    /* RESPONSIVE */
    @media (max-width: 1024px) {
      .profile-container {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .profile-title {
        font-size: 36px;
      }
    }

    @media (max-width: 768px) {
      .profile-main-content {
        padding: 30px 20px;
      }

      .profile-container {
        gap: 30px;
      }

      .profile-title {
        font-size: 28px;
      }

      .form-input {
        padding: 12px 16px;
        font-size: 13px;
      }

      .avatar-container {
        width: 150px;
        height: 150px;
      }
    }

    @media (max-width: 576px) {
      .profile-main-content {
        padding: 20px 15px;
      }

      .profile-title {
        font-size: 24px;
        margin-bottom: 20px;
      }

      .form-input {
        padding: 10px 14px;
        font-size: 12px;
      }

      .avatar-container {
        width: 120px;
        height: 120px;
        font-size: 14px;
      }

      .profile-buttons {
        flex-direction: column;
      }
    }
</style>
@endpush

@section('content')
<main class="profile-main-content">
    <form method="POST" action="{{ route('perfil.actualizar') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="profile-container">
            <!-- TÍTULO -->
            <h1 class="profile-title">Editar Perfil</h1>

            <!-- FORMULARIO -->
            <div class="form-section">
                <input
                    type="text"
                    class="form-input"
                    name="name"
                    placeholder="Nombre..."
                    value="{{ old('name', auth()->user()->name) }}"
                    required
                >
                <input
                    type="text"
                    class="form-input"
                    name="apellidos"
                    placeholder="Apellidos..."
                    value="{{ old('apellidos', auth()->user()->apellidos ?? '') }}"
                >
                <input
                    type="email"
                    class="form-input"
                    name="email"
                    placeholder="Email"
                    value="{{ old('email', auth()->user()->email) }}"
                    required
                >
                <input
                    type="password"
                    class="form-input"
                    name="password"
                    placeholder="Contraseña... (dejar en blanco para no cambiar)"
                >
                <input
                    type="password"
                    class="form-input"
                    name="password_confirmation"
                    placeholder="Repetir contraseña..."
                >
                <input
                    type="tel"
                    class="form-input"
                    name="telefono"
                    placeholder="+34 999...."
                    value="{{ old('telefono', auth()->user()->telefono ?? '') }}"
                >
                <input
                    type="text"
                    class="form-input"
                    name="direccion"
                    placeholder="Calle Huertas nº 15..."
                    value="{{ old('direccion', auth()->user()->direccion ?? '') }}"
                >
            </div>

            <!-- AVATAR -->
            <div class="avatar-section">
                <label for="avatarInput" class="avatar-container" id="avatarDisplay">
                    @if(auth()->user()->avatar ?? false)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar">
                    @else
                        Subir imagen
                    @endif
                </label>
                <input
                    type="file"
                    class="avatar-input"
                    name="avatar"
                    id="avatarInput"
                    accept="image/*"
                >
            </div>

            <!-- BOTONES -->
            <div class="profile-buttons">
                <button type="submit" class="btn-profile-save">
                    <i class="fas fa-check"></i> Guardar cambios
                </button>
                <a href="{{ route('catalogo') }}" class="btn-profile-cancel" style="text-decoration: none; text-align: center; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    // Preview de imagen al seleccionar archivo
    const avatarInput = document.getElementById('avatarInput');
    const avatarDisplay = document.getElementById('avatarDisplay');

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarDisplay.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
