@extends('layouts.auth')

@section('title', 'Recuperar Contraseña - IA Decorate')

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
      margin-bottom: 15px;
      color: var(--text-dark);
      letter-spacing: -1px;
    }

    .auth-subtitle {
      font-size: 14px;
      text-align: center;
      margin-bottom: 20px;
      color: var(--text-light);
      font-weight: 600;
    }

    .auth-description {
      font-size: 14px;
      text-align: center;
      margin-bottom: 25px;
      color: var(--text-light);
      line-height: 1.5;
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

    .input-icon-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 18px;
      cursor: pointer;
      color: var(--text-dark);
      pointer-events: none;
    }

    .form-control.with-icon {
      padding-right: 50px;
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

    /* ===========================
       LINKS Y TEXTOS
       =========================== */

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
       MENSAJES DE ÉXITO
       =========================== */

    .alert {
      padding: 12px 16px;
      border-radius: var(--input-radius);
      margin-bottom: 20px;
      font-size: 14px;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border: none;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      border: none;
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
        margin-bottom: 10px;
      }

      .form-control {
        padding: 12px 16px;
        font-size: 13px;
      }

      .btn-auth {
        padding: 14px 18px;
        font-size: 15px;
      }

      .input-icon {
        font-size: 16px;
      }
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <!-- Título -->
        <h1 class="auth-title">Recuperación de la contraseña</h1>

        <!-- Subtítulo -->
        <p class="auth-subtitle">CAMBIA TU CONTRASEÑA:</p>

        <!-- Mensaje de sesión si existe -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <!-- Formulario de Recuperación -->
        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf

            <!-- Descripción -->
            <p class="auth-description">
                Indica tu correo electrónico y sigue las instrucciones que se envían por correo.
            </p>

            <!-- Email -->
            <div class="form-group">
                <div class="input-icon-wrapper">
                    <input
                        type="email"
                        class="form-control with-icon @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="tu@email.com"
                        required
                        autocomplete="email"
                    >
                    <span class="input-icon">✉️</span>
                </div>
                @error('email')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Botón Enviar -->
            <button type="submit" class="btn btn-auth btn-auth-primary">
                Enviar
            </button>
        </form>

        <!-- Link de ayuda -->
        <div class="auth-footer-text">
            <a href="{{ route('login') }}">Volver al login</a>
        </div>
    </div>
</div>

<script>
    // Limpiar validación al escribir
    (function () {
        'use strict';
        const email = document.getElementById('email');
        email.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const feedback = this.parentElement.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.style.display = 'none';
            }
        });
    })();
</script>
@endsection
