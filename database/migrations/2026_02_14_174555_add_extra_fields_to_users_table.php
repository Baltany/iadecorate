<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono', 20)->nullable()->after('email');
            $table->text('direccion')->nullable()->after('telefono');
            $table->string('avatar')->nullable()->after('direccion');
            $table->date('fecha_nacimiento')->nullable()->after('avatar');
            $table->string('apellidos')->nullable()->after('name');
            $table->string('ciudad', 100)->nullable()->after('direccion');
            $table->string('codigo_postal', 10)->nullable()->after('ciudad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'direccion', 'avatar', 'fecha_nacimiento', 'apellidos', 'ciudad', 'codigo_postal']);
        });
    }
};
