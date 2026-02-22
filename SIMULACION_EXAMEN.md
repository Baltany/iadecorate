# 🎓 SIMULACIÓN DE EXAMEN - PREGUNTAS DEL PROFESOR

## 📋 PRÁCTICA DE PREGUNTAS Y RESPUESTAS

---

## 🟢 NIVEL 1: PREGUNTAS BÁSICAS (Ubicación de archivos)

### Pregunta 1: "¿Dónde está el código que muestra el catálogo de productos?"

**📍 Respuesta correcta:**
> El catálogo está implementado en varios archivos:
> 
> - **Ruta:** En `routes/web.php` línea 31, defino `Route::get('/catalogo', [ProductoController::class, 'index'])`
> 
> - **Controlador:** En `app/Http/Controllers/ProductoController.php`, método `index()` (línea 17-30)
> 
> - **Modelo:** Usa el modelo `Producto` de `app/Models/Producto.php` para consultar la base de datos
> 
> - **Vista:** La vista está en `resources/views/cliente/catalogo.blade.php`

**💡 Bonus si añades:** "He añadido funcionalidad de búsqueda que filtra por nombre o descripción usando `LIKE` en la consulta."

---

### Pregunta 2: "¿Qué middleware protege las rutas de administrador?"

**📍 Respuesta correcta:**
> Las rutas de administrador están protegidas por tres middleware en `routes/web.php` línea 82:
> 
> ```php
> Route::middleware(['auth', 'verified', 'role:admin'])
> ```
> 
> - **`auth`**: Verifica que el usuario esté autenticado (que haya hecho login)
> - **`verified`**: Verifica que el email esté verificado
> - **`role:admin`**: Este es un middleware personalizado que creé en `app/Http/Middleware/CheckRole.php` que verifica que el usuario tenga el rol de administrador

**💡 Bonus:** "Si un usuario sin permisos intenta acceder, el middleware lanza un error 403 Forbidden."

---

### Pregunta 3: "Enséñame el método que agrega productos al carrito"

**📍 Respuesta correcta:**
> Está en `app/Http/Controllers/CarritoController.php`, método `agregar()`.
> 
> **Abriendo el archivo y explicando:**
> 
> ```php
> public function agregar(Producto $producto)
> {
>     // Primero verifico si el producto tiene stock
>     if ($producto->stock <= 0) {
>         return redirect()->back()->with('error', 'Producto sin stock');
>     }
>     
>     // Busco si ya existe en el carrito del usuario
>     $carritoItem = Carrito::where('user_id', auth()->id())
>                           ->where('producto_id', $producto->id)
>                           ->first();
>     
>     if ($carritoItem) {
>         // Si ya existe, incremento la cantidad
>         $carritoItem->increment('cantidad');
>     } else {
>         // Si no existe, creo uno nuevo
>         Carrito::create([
>             'user_id' => auth()->id(),
>             'producto_id' => $producto->id,
>             'cantidad' => 1
>         ]);
>     }
>     
>     return redirect()->route('carrito');
> }
> ```
> 
> El método usa **inyección de dependencias** con `Producto $producto`, Laravel lo resuelve automáticamente desde el ID de la ruta.

---

## 🟡 NIVEL 2: PREGUNTAS DE LÓGICA (Cómo funciona)

### Pregunta 4: "Explícame el flujo completo cuando un usuario compra algo"

**📍 Respuesta correcta:**
> El flujo de compra tiene varios pasos:
> 
> **1. Ver productos** (`/catalogo`)
> - Ruta: `GET /catalogo` → `ProductoController@index`
> - Consulta: `Producto::where('stock', '>', 0)->get()`
> - Vista: `cliente/catalogo.blade.php`
> 
> **2. Agregar al carrito** (`POST /carrito/agregar/{producto}`)
> - Controlador: `CarritoController@agregar`
> - Verifica stock disponible
> - Crea o incrementa registro en tabla `carritos`
> 
> **3. Ver carrito** (`/carrito`)
> - Controlador: `CarritoController@index`
> - Consulta: `Carrito::where('user_id', auth()->id())->with('producto')->get()`
> - Calcula subtotal (suma de productos) + envío (5.99€)
> - Vista: `cliente/carrito.blade.php`
> 
> **4. Checkout** (`/checkout`)
> - Controlador: `PedidoController@checkout`
> - Muestra resumen y formulario de dirección
> - Vista: `cliente/checkout.blade.php`
> 
> **5. Crear pedido** (`POST /pedido/crear`)
> - Controlador: `PedidoController@crear`
> - Dentro de una transacción:
>   - a) Crea registro en tabla `pedidos`
>   - b) Crea registros en `detalle_pedidos` por cada producto
>   - c) Reduce el stock de cada producto
>   - d) Vacía el carrito del usuario
>   - e) Envía notificación `PedidoCreadoNotification`
> 
> **6. Confirmación** (`/pedido/{id}`)
> - Muestra el detalle del pedido creado
> - Vista: `cliente/pedido-detalle.blade.php`

**💡 Bonus:** "Uso transacciones para garantizar que si algo falla, todo se revierte y no quedan datos inconsistentes."

---

### Pregunta 5: "¿Qué pasa si dos usuarios intentan comprar el último producto al mismo tiempo?"

**📍 Respuesta correcta:**
> Actualmente tengo una verificación básica de stock en el momento de agregar al carrito:
> 
> ```php
> if ($producto->stock <= 0) {
>     return redirect()->back()->with('error', 'Producto sin stock');
> }
> ```
> 
> Y cuando se crea el pedido, se reduce el stock:
> 
> ```php
> $producto->decrement('stock', $cantidad);
> ```
> 
> **Posible problema:** Si dos usuarios agregan al carrito casi al mismo tiempo, ambos podrían ver stock disponible.
> 
> **Solución que implementaría:** Usar **bloqueos optimistas** o verificar stock en el momento de crear el pedido, no solo al agregar al carrito. También podría usar transacciones con `lockForUpdate()` en Laravel.

**💡 Esto muestra que:** Entiendes los problemas de concurrencia y sabes que hay mejoras posibles.

---

### Pregunta 6: "¿Cómo funciona el sistema de roles? ¿Cómo sabes si un usuario es admin?"

**📍 Respuesta correcta:**
> He implementado un sistema de roles con tabla pivote:
> 
> **Base de datos:**
> - Tabla `roles` → id, nombre ('admin', 'cliente')
> - Tabla `role_user` (pivot) → user_id, role_id
> 
> **En el modelo User** (`app/Models/User.php`):
> ```php
> public function roles() {
>     return $this->belongsToMany(Rol::class);
> }
> 
> public function hasRole($role) {
>     return $this->roles()->where('nombre', $role)->exists();
> }
> 
> public function hasAnyRole($roles) {
>     return $this->roles()->whereIn('nombre', $roles)->exists();
> }
> ```
> 
> **Uso en middleware** (`CheckRole.php`):
> ```php
> if (!Auth::user()->hasAnyRole($roles)) {
>     abort(403, 'No tienes permisos');
> }
> ```
> 
> **En las rutas:**
> ```php
> Route::middleware(['auth', 'role:admin'])->group(function() {
>     // Rutas solo para admin
> });
> ```

**💡 Bonus:** "La relación many-to-many permite que un usuario tenga múltiples roles si fuera necesario en el futuro."

---

## 🔴 NIVEL 3: PREGUNTAS TÉCNICAS (Decisiones de diseño)

### Pregunta 7: "¿Por qué has separado las validaciones en Form Requests en lugar de poner todo en el controlador?"

**📍 Respuesta correcta:**
> He usado Form Requests por varias razones de buenas prácticas:
> 
> **1. Separación de responsabilidades:**
> - El controlador se enfoca en la lógica de negocio
> - El Request se enfoca en validación y autorización
> 
> **2. Reutilización:**
> - Puedo usar el mismo `ProductoRequest` en `store()` y `update()`
> - No duplico código de validación
> 
> **3. Código más limpio:**
> 
> **Sin Request (antes):**
> ```php
> public function store(Request $request) {
>     $validated = $request->validate([
>         'nombre' => 'required|string|max:255',
>         'precio' => 'required|numeric|min:0',
>         // ... 15 líneas más de validación
>     ]);
>     Producto::create($validated);
> }
> ```
> 
> **Con Request (ahora):**
> ```php
> public function store(ProductoRequest $request) {
>     Producto::create($request->validated());
> }
> ```
> 
> **4. Autorización centralizada:**
> - En el Request puedo verificar permisos:
> ```php
> public function authorize(): bool {
>     return Auth::user()->hasRole('admin');
> }
> ```
> 
> **5. Mensajes personalizados en español:**
> ```php
> public function messages(): array {
>     return [
>         'nombre.required' => 'El nombre es obligatorio',
>         'precio.min' => 'El precio debe ser mayor a 0'
>     ];
> }
> ```

**💡 Esto demuestra:** Conoces las best practices de Laravel y sabes justificar tus decisiones.

---

### Pregunta 8: "¿Por qué has creado controladores separados en /Api/ en lugar de usar los mismos controladores?"

**📍 Respuesta correcta:**
> He separado los controladores de API por varios motivos:
> 
> **1. Respuestas diferentes:**
> - Controladores web → retornan vistas Blade (`return view(...)`)
> - Controladores API → retornan JSON (`return response()->json(...)`)
> 
> **2. Autenticación diferente:**
> - Web → usa sesiones (`auth` middleware)
> - API → usa tokens (`auth:sanctum` middleware)
> 
> **3. Validación diferente:**
> - Web → puede redirigir con errores
> - API → debe retornar errores en JSON
> 
> **4. Lógica potencialmente diferente:**
> - Web puede necesitar vistas adicionales
> - API es más directo: CRUD puro
> 
> **Ejemplo comparación:**
> 
> **ProductoController (web):**
> ```php
> public function index() {
>     $productos = Producto::where('stock', '>', 0)->get();
>     return view('cliente.catalogo', compact('productos'));
> }
> ```
> 
> **Api\ProductoController:**
> ```php
> public function index() {
>     $productos = Producto::where('stock', '>', 0)->get();
>     return response()->json(['data' => $productos]);
> }
> ```

**💡 Bonus:** "Podría haber usado el mismo controlador con condicionales, pero separarlo hace el código más mantenible y sigue el principio de Single Responsibility."

---

### Pregunta 9: "Veo que usas Eloquent. ¿Podrías escribir la consulta SQL equivalente de este código?"

```php
$pedido = Pedido::with(['usuario', 'detalles.producto'])
                ->where('id', $id)
                ->first();
```

**📍 Respuesta correcta:**
> Esta consulta de Eloquent usa **eager loading** para evitar el problema N+1. El SQL equivalente sería:
> 
> ```sql
> -- Primera consulta: obtiene el pedido
> SELECT * FROM pedidos WHERE id = ? LIMIT 1;
> 
> -- Segunda consulta: obtiene el usuario relacionado
> SELECT * FROM users WHERE id = ?;
> 
> -- Tercera consulta: obtiene los detalles del pedido
> SELECT * FROM detalle_pedidos WHERE pedido_id = ?;
> 
> -- Cuarta consulta: obtiene los productos de los detalles
> SELECT * FROM productos WHERE id IN (?, ?, ?);
> ```
> 
> **Ventaja de with():** Sin el `with()`, si luego hago `foreach` sobre los detalles, Eloquent haría una consulta SQL por cada detalle (problema N+1). Con `with()`, Eloquent hace solo 3-4 consultas independientemente del número de detalles.
> 
> **Alternativa sin Eloquent (SQL puro con JOINs):**
> ```sql
> SELECT 
>     pedidos.*,
>     users.name, users.email,
>     productos.nombre, productos.precio,
>     detalle_pedidos.cantidad
> FROM pedidos
> LEFT JOIN users ON pedidos.user_id = users.id
> LEFT JOIN detalle_pedidos ON pedidos.id = detalle_pedidos.pedido_id
> LEFT JOIN productos ON detalle_pedidos.producto_id = productos.id
> WHERE pedidos.id = ?;
> ```

**💡 Esto demuestra:** Entiendes cómo Eloquent traduce a SQL y conoces los problemas de rendimiento (N+1).

---

### Pregunta 10: "¿Qué es Laravel Fortify y por qué lo usas?"

**📍 Respuesta correcta:**
> Laravel Fortify es un paquete oficial de Laravel para **autenticación backend sin interfaz**.
> 
> **¿Qué hace?**
> - Login
> - Registro
> - Verificación de email
> - Recuperación de contraseña
> - Autenticación de dos factores (2FA)
> 
> **¿Por qué lo uso?**
> 
> **Ventajas:**
> 1. **No reinventar la rueda:** La autenticación es compleja (hashing de passwords, tokens, seguridad). Fortify ya lo hace bien.
> 
> 2. **Sin frontend acoplado:** A diferencia de Laravel Breeze/Jetstream, Fortify solo provee el backend. Yo creo mis propias vistas.
> 
> 3. **Personalizable:** Puedo sobreescribir comportamientos. Por ejemplo, en `Auth/RegisterController.php` personalicé que NO haga login automático después del registro.
> 
> 4. **Seguro:** Incluye protección contra ataques comunes (brute force, CSRF, etc.)
> 
> **Configuración:**
> En `config/fortify.php` activo/desactivo funcionalidades:
> ```php
> 'features' => [
>     Features::registration(),
>     Features::resetPasswords(),
>     Features::emailVerification(),
> ],
> ```
> 
> **Personalización:**
> Si necesito cambiar algo, puedo hacerlo en `app/Actions/Fortify/` o crear controladores en `Auth/`.

**💡 Alternativas:** "Podría haber usado Laravel Breeze (más simple) o implementarlo desde cero, pero Fortify es el equilibrio perfecto entre control y no tener que programar todo."

---

## 🟣 NIVEL 4: PREGUNTAS SORPRESA (Demostrar conocimiento profundo)

### Pregunta 11: "Si tuvieras que añadir un sistema de cupones de descuento, ¿cómo lo harías?"

**📍 Respuesta correcta:**
> Implementaría un sistema de cupones siguiendo estos pasos:
> 
> **1. Crear migración y modelo:**
> ```php
> // Migration: create_cupones_table
> Schema::create('cupones', function (Blueprint $table) {
>     $table->id();
>     $table->string('codigo')->unique();
>     $table->decimal('descuento', 8, 2); // Porcentaje o cantidad fija
>     $table->enum('tipo', ['porcentaje', 'fijo']);
>     $table->date('fecha_inicio');
>     $table->date('fecha_expiracion');
>     $table->integer('usos_maximos')->nullable();
>     $table->integer('usos_actuales')->default(0);
>     $table->boolean('activo')->default(true);
>     $table->timestamps();
> });
> ```
> 
> **2. Relación con pedidos:**
> - Añadir campo `cupon_id` (nullable) en tabla `pedidos`
> - Añadir campo `descuento_aplicado` en tabla `pedidos`
> 
> **3. Crear modelo Cupon:**
> ```php
> class Cupon extends Model {
>     public function esValido() {
>         return $this->activo 
>             && now()->between($this->fecha_inicio, $this->fecha_expiracion)
>             && ($this->usos_maximos === null || $this->usos_actuales < $this->usos_maximos);
>     }
> }
> ```
> 
> **4. Modificar PedidoController:**
> - En el checkout, añadir input para código de cupón
> - Validar cupón antes de crear pedido
> - Aplicar descuento al total
> - Incrementar `usos_actuales` del cupón
> 
> **5. Crear CuponController en admin:**
> - CRUD para gestionar cupones
> - Ver estadísticas de uso

**💡 Esto demuestra:** Sabes planificar nuevas funcionalidades y entiendes la arquitectura del sistema.

---

### Pregunta 12: "Muéstrame las relaciones entre Pedido y Producto"

**📍 Respuesta correcta:**
> La relación entre Pedido y Producto es **muchos a muchos** (many-to-many), pero con datos adicionales (cantidad, precio_unitario), por eso uso una **tabla intermedia** llamada `detalle_pedidos`.
> 
> **Estructura:**
> 
> ```
> pedidos          detalle_pedidos        productos
> ├─ id            ├─ id                  ├─ id
> ├─ user_id       ├─ pedido_id           ├─ nombre
> ├─ total         ├─ producto_id         ├─ precio
> └─ estado        ├─ cantidad            └─ stock
>                  └─ precio_unitario
> ```
> 
> **En el modelo Pedido** (`app/Models/Pedido.php`):
> ```php
> public function detalles() {
>     return $this->hasMany(DetallePedido::class);
> }
> 
> // Acceso directo a productos a través de detalles
> public function productos() {
>     return $this->hasManyThrough(Producto::class, DetallePedido::class);
> }
> ```
> 
> **En el modelo Producto:**
> ```php
> public function detallesPedido() {
>     return $this->hasMany(DetallePedido::class);
> }
> ```
> 
> **En el modelo DetallePedido:**
> ```php
> public function pedido() {
>     return $this->belongsTo(Pedido::class);
> }
> 
> public function producto() {
>     return $this->belongsTo(Producto::class);
> }
> ```
> 
> **¿Por qué una tabla intermedia extra?**
> - Necesito guardar `precio_unitario` porque el precio puede cambiar después
> - Necesito guardar `cantidad` para saber cuántas unidades se compraron
> - No puedo usar `belongsToMany` simple porque necesito estos campos extra

**💡 Bonus:** "Guardo el precio_unitario en el momento de la compra para mantener un histórico, aunque el precio del producto cambie después."

---

### Pregunta 13: "¿Qué harías si el servidor se cae en medio de crear un pedido?"

**📍 Respuesta correcta:**
> Para protegerme contra fallos durante la creación del pedido, uso **transacciones de base de datos**:
> 
> **En PedidoController:**
> ```php
> use Illuminate\Support\Facades\DB;
> 
> public function crear(Request $request) {
>     try {
>         DB::beginTransaction();
>         
>         // 1. Crear pedido
>         $pedido = Pedido::create([...]);
>         
>         // 2. Crear detalles
>         foreach ($carritoItems as $item) {
>             DetallePedido::create([...]);
>         }
>         
>         // 3. Reducir stock
>         foreach ($carritoItems as $item) {
>             $item->producto->decrement('stock', $item->cantidad);
>         }
>         
>         // 4. Vaciar carrito
>         Carrito::where('user_id', auth()->id())->delete();
>         
>         // 5. Confirmar transacción
>         DB::commit();
>         
>         return redirect()->route('pedido.detalle', $pedido->id);
>         
>     } catch (\Exception $e) {
>         // Si algo falla, revertir TODO
>         DB::rollBack();
>         
>         return redirect()->back()->with('error', 'Error al crear pedido');
>     }
> }
> ```
> 
> **¿Qué garantiza esto?**
> - Si falla en paso 3, los pasos 1 y 2 se revierten
> - No queda un pedido a medias
> - No se reduce el stock parcialmente
> - Todo o nada (atomicidad)
> 
> **Mejoras adicionales que implementaría:**
> - **Jobs en cola** para tareas no críticas (enviar email)
> - **Retry automático** con Laravel Queue
> - **Logs** para debugging: `Log::error('Error creando pedido', ['error' => $e])`

**💡 Esto demuestra:** Entiendes conceptos de bases de datos (transacciones ACID) y piensas en robustez.

---

### Pregunta 14: "¿Cómo evitas ataques de inyección SQL?"

**📍 Respuesta correcta:**
> Laravel me protege automáticamente de inyección SQL de varias formas:
> 
> **1. Eloquent ORM:**
> Cuando uso Eloquent, Laravel usa **prepared statements** automáticamente:
> ```php
> // SEGURO - Laravel escapa los valores automáticamente
> Producto::where('nombre', $request->input('buscar'))->get();
> ```
> 
> Internamente Laravel hace:
> ```sql
> SELECT * FROM productos WHERE nombre = ? -- El ? es un placeholder
> -- Y luego vincula el valor de forma segura
> ```
> 
> **2. Query Builder:**
> También usa prepared statements:
> ```php
> DB::table('productos')
>   ->where('precio', '>', $precio)
>   ->get();
> ```
> 
> **3. Validación:**
> Los Form Requests validan y sanitizan los datos:
> ```php
> 'email' => 'required|email',  // Solo acepta emails válidos
> 'precio' => 'required|numeric', // Solo acepta números
> ```
> 
> **❌ NUNCA HAGO ESTO (peligroso):**
> ```php
> // VULNERABLE A INYECCIÓN SQL
> DB::raw("SELECT * FROM productos WHERE nombre = '{$request->nombre}'");
> ```
> 
> **✅ Si necesito raw queries:**
> ```php
> // SEGURO - Con bindings
> DB::select("SELECT * FROM productos WHERE nombre = ?", [$request->nombre]);
> ```
> 
> **Otras protecciones:**
> - **CSRF tokens** en formularios (`@csrf`)
> - **XSS protection** con Blade (auto-escapa HTML: `{{ $variable }}`)
> - **Mass assignment protection** con `$fillable` en modelos

**💡 Esto demuestra:** Entiendes seguridad web y confías en las protecciones de Laravel, pero sabes cuándo podrías estar vulnerable.

---

### Pregunta 15: "Si tengo 10,000 productos, ¿tu catálogo irá lento?"

**📍 Respuesta correcta:**
> Sí, probablemente iría lento. Actualmente no tengo optimizaciones para gran volumen. **Mejoras que implementaría:**
> 
> **1. Paginación:**
> ```php
> // En ProductoController:
> $productos = Producto::where('stock', '>', 0)->paginate(20);
> 
> // En la vista:
> {{ $productos->links() }}
> ```
> 
> **2. Caché:**
> ```php
> $productos = Cache::remember('productos_catalogo', 3600, function() {
>     return Producto::where('stock', '>', 0)->get();
> });
> ```
> 
> **3. Eager Loading (ya lo implemento):**
> ```php
> $pedidos = Pedido::with('detalles.producto')->get();
> // Evita el problema N+1
> ```
> 
> **4. Índices en base de datos:**
> ```php
> // En migration:
> $table->index('stock');
> $table->index('created_at');
> ```
> 
> **5. Select específico (solo columnas necesarias):**
> ```php
> Producto::select('id', 'nombre', 'precio', 'imagen')
>         ->where('stock', '>', 0)
>         ->get();
> // No carga 'descripcion' si no la necesito
> ```
> 
> **6. Lazy loading de imágenes:**
> ```html
> <img src="..." loading="lazy">
> ```
> 
> **7. Queue para tareas pesadas:**
> - Generación de reportes
> - Envío de emails
> - Procesamiento de imágenes

**💡 Esto demuestra:** Piensas en escalabilidad y performance, aunque aún no lo hayas implementado todo.

---

## 📊 RESUMEN DE CÓMO RESPONDER

### ✅ Estructura de una buena respuesta:

1. **Ubicación exacta:**
   - "El código está en `ruta/archivo.php` línea X"
   
2. **Qué hace:**
   - "Este método/función gestiona [funcionalidad]"
   
3. **Cómo funciona:**
   - Explica la lógica paso a paso
   
4. **Por qué así:**
   - Justifica decisiones técnicas
   
5. **Bonus (si puedes):**
   - Menciona mejoras posibles
   - Demuestra que entiendes limitaciones

---

## 🎯 CONSEJOS FINALES

### ✅ HACER:
- Ser específico con rutas de archivos
- Mostrar el código mientras explicas
- Reconocer limitaciones y sugerir mejoras
- Usar terminología técnica correcta (ORM, middleware, migration, etc.)

### ❌ NO HACER:
- Decir "no sé" (mejor: "aún no lo he implementado pero lo haría así...")
- Inventar funcionalidades que no tienes
- Contradecirte entre respuestas
- Usar términos que no entiendes

---

## 🏆 PREGUNTA BONUS FINAL

### "¿Qué es lo más complejo que has implementado en este proyecto?"

**📍 Respuesta sugerida:**
> Lo más complejo ha sido el **flujo completo de creación de pedidos** en `PedidoController@crear`.
> 
> **Desafíos:**
> 
> 1. **Atomicidad:** Usar transacciones para garantizar que todo se complete o nada
> 
> 2. **Consistencia de datos:** Guardar precio_unitario en el momento de compra, no referenciar el precio actual
> 
> 3. **Gestión de stock:** Reducir stock de productos y manejar casos donde no hay suficiente
> 
> 4. **Relaciones múltiples:** Coordinar User → Pedido → DetallePedido → Producto
> 
> 5. **Notificaciones:** Enviar emails tanto al cliente como al admin
> 
> **Código clave** (`PedidoController.php` línea ~50-100):
> ```php
> DB::beginTransaction();
> 
> // Crear pedido
> $pedido = Pedido::create([
>     'user_id' => auth()->id(),
>     'total' => $total,
>     'estado' => 'pendiente',
>     // ... datos de envío
> ]);
> 
> // Crear detalles y reducir stock
> foreach ($carritoItems as $item) {
>     DetallePedido::create([
>         'pedido_id' => $pedido->id,
>         'producto_id' => $item->producto_id,
>         'cantidad' => $item->cantidad,
>         'precio_unitario' => $item->producto->precio, // Crucial!
>     ]);
>     
>     $item->producto->decrement('stock', $item->cantidad);
> }
> 
> // Vaciar carrito
> Carrito::where('user_id', auth()->id())->delete();
> 
> DB::commit();
> ```
> 
> **Aprendizajes:**
> - Importancia de las transacciones
> - Guardar snapshots de datos que pueden cambiar
> - Manejar errores con try-catch
> - Usar eager loading para evitar N+1

---

**¡Con esto estás más que preparado!** 🚀

Lee estas preguntas, practica las respuestas en voz alta, y estarás listo para cualquier pregunta del profesor. Recuerda: si te quedas en blanco, siempre puedes abrir el archivo y explicar mientras lo muestras. ¡Suerte! 💪
