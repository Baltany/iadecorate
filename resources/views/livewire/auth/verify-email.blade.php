@extends('layouts.auth')

@section('title', 'Verificar Email - IA Decorate')

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
            max-width: 500px;
            animation: fadeInUp 0.6s ease-out;
        }

        .auth-title {
            font-size: 32px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 30px;
            color: var(--text-dark);
            letter-spacing: -1px;
        }

        .verify-icon {
            text-align: center;
            font-size: 64px;
            margin-bottom: 20px;
        }

        .verify-text {
            text-align: center;
            color: var(--text-dark);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
        }

        .btn-auth {
            width: 100%;
            padding: 16px 20px;
            border: none;
            border-radius: var(--input-radius);
            font-size: 16px;
            font-weight: 900;
            background-color: var(--text-dark);
            color: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        .btn-auth:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-dark);
            border: 2px solid var(--text-dark);
        }

        .btn-secondary:hover {
            background-color: var(--text-dark);
            color: var(--white);
        }

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

        @media (max-width: 576px) {
            .auth-card {
                padding: 40px 25px;
            }

            .auth-title {
                font-size: 26px;
            }

            .verify-text {
                font-size: 14px;
            }
        }
    </style>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Título -->
            <h1 class="auth-title">VERIFICACIÓN DE EMAIL</h1>

            <!-- Icono -->
            <div class="verify-icon">📧</div>

            <!-- Texto informativo -->
            <p class="verify-text">
                Por favor verifica tu correo electrónico haciendo clic en el enlace que te acabamos de enviar a
                <strong>{{ Auth::user()->email }}</strong>
            </p>

            <!-- Mensaje de éxito si se reenvió el email -->
            @if (session('status') == 'verification-link-sent')
                <div class="success-message">
                    ✓ Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                </div>
            @endif

            <!-- Formulario para reenviar verificación -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-auth">
                    Reenviar correo de verificación
                </button>
            </form>

            <!-- Formulario de logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-auth btn-secondary">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
@endsection
