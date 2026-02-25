<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'telefono',
        'direccion',
        'avatar',
        'fecha_nacimiento',
        'ciudad',
        'codigo_postal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Obtiener los atributos que deben ser convertidos a tipos nativos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Obtiener las iniciales del nombre del usuario para mostrar en el avatar
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Relación N:M con roles
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'role_user', 'user_id', 'role_id');
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($role)
    {
        return $this->roles()->where('nombre', $role)->exists();
    }

    /**
     * Verificar si el usuario tiene alguno de los roles
     */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('nombre', $roles)->exists();
    }

    /**
     * Enviar notificación de verificación de email con manejo de errores
     */
    public function sendEmailVerificationNotification()
    {
        try {
            $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
        } catch (\Exception $e) {
            // Registrar error pero no interrumpir el proceso de registro
            \Illuminate\Support\Facades\Log::error('Error al enviar email de verificación: ' . $e->getMessage());
        }
    }
}
