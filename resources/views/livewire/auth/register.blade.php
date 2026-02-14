@extends('layouts.auth')

@section('title', 'Registro - IA Decorate')

@section('content')
<style>
    :root {
      --primary-color: #EED09D;
      --primary-dark: #E0C080;
      --text-dark: #1a1a1a;
      --text-light: #666;
      --white: #ffffff;
      --border-radius: 50px;
      --input-radius: 25px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      height: 100%;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--text-dark);
      background-color: #f5f5f5;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ===========================
       AUTH CONTAINER PRINCIPAL
       =========================== */

    .auth-container {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
      padding: 20px;
    }

    .auth-card {
      background: var(--primary-color);
      border-radius: var(--border-radius);
      padding: 60px 40px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
      animation: fadeInUp 0.6s ease-out;
    }

    /* ===========================
       TÍTULOS Y ENCABEZADOS
       =========================== */

    .auth-title {
      font-size: 32px;
      font-weight: 900;
      text-align: center;
      margin-bottom: 50px;
      color: var(--text-dark);
      letter-spacing: -1px;
    }

    /* ===========================
       CAMPOS DE FORMULARIO
       =========================== */

    .form-group {
      margin-bottom: 25px;
    }

    .form-label {
      display: block;
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 12px;
      color: var(--text-dark);
    }

    .form-control {
      width: 100%;
      padding: 15px 20px;
      border: none;
      border-radius: var(--input-radius);
      font-size: 14px;
      background-color: var(--white);
      color: var(--text-dark);
      transition: box-shadow 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
      background-color: var(--white);
    }

    .form-control::placeholder {
      color: #999;
    }

    /* ===========================
       BOTONES
       =========================== */

    .btn-auth {
      width: 100%;
      padding: 16px 20px;
      border: none;
      border-radius: var(--input-radius);
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 20px;
    }

    .btn-auth-primary {
      background-color: var(--white);
      color: var(--text-dark);
    }

    .btn-auth-primary:hover {
      background-color: #f9f9f9;
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-auth-secondary {
      background-color: transparent;
      color: var(--text-dark);
      border: 2px solid var(--text-dark);
    }

    .btn-auth-secondary:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    /* ===========================
       LINKS Y TEXTOS
       =========================== */

    .auth-links {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 15px;
    }

    .auth-link {
      font-size: 14px;
      color: var(--text-dark);
      text-decoration: none;
      font-weight: 600;
    }

    .auth-link:hover {
      text-decoration: underline;
    }

    .auth-footer-text {
      text-align: center;
      font-size: 14px;
      margin-top: 30px;
      color: var(--text-dark);
    }

    .auth-footer-text a {
      color: var(--text-dark);
      font-weight: 700;
      text-decoration: none;
    }

    .auth-footer-text a:hover {
      text-decoration: underline;
    }

    /* ===========================
       VALIDACIÓN DE FORMULARIOS
       =========================== */

    .form-control.is-invalid {
      border-color: #dc3545;
      box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .invalid-feedback {
      display: block;
      color: #dc3545;
      font-size: 13px;
      margin-top: 5px;
    }

    /* ===========================
       ANIMACIONES
       =========================== */

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* ===========================
       LAYOUT RESPONSIVO
       =========================== */

    @media (max-width: 576px) {
      .auth-card {
        padding: 40px 25px;
      }

      .auth-title {
        font-size: 26px;
        margin-bottom: 40px;
      }

      .form-label {
        font-size: 14px;
      }

      .form-control {
        padding: 12px 16px;
        font-size: 13px;
      }

      .btn-auth {
        padding: 14px 18px;
        font-size: 15px;
      }

      .auth-links {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

      .auth-link {
        text-align: center;
      }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Título -->
        <h1 class="auth-title">REGÍSTRATE EN<br>IA DECORATE</h1>

        <!-- Formulario de Registro -->
        <form method="POST" action="{{ route('register') }}" novalidate>
            @csrf

            <!-- Nombre -->
            <div class="form-group">
                <label for="name" class="form-label">Nombre</label>
                <input
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Tu nombre"
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="tu@email.com"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                >
                @error('password')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                >
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <button type="submit" class="btn btn-auth btn-auth-primary" style="flex: 1;">
                    Aceptar
                </button>
                <button type="reset" class="btn btn-auth btn-auth-secondary" style="flex: 1;">
                    Cancelar
                </button>
            </div>
        </form>

        <!-- Link de login -->
        <div class="auth-footer-text">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </div>
</div>
@endsection
