<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si estás en otra carpeta

use Dotenv\Dotenv;

/**
 * Clase Conexion
 * 
 * Esta clase gestiona la conexión a una base de datos MySQL utilizando la extensión mysqli.
 * Proporciona métodos para obtener la conexión activa y cerrarla cuando ya no sea necesaria.
 * 
 * Propiedades:
 * - $host (string): Dirección del servidor de base de datos.
 * - $usuario (string): Nombre de usuario para la conexión.
 * - $password (string): Contraseña para la conexión.
 * - $baseDatos (string): Nombre de la base de datos.
 * - $conexion (mysqli): Objeto que representa la conexión activa.
 * 
 * Métodos:
 * - __construct(): Inicializa la conexión a la base de datos utilizando credenciales definidas en un archivo .env.
 *   Configura el conjunto de caracteres a "utf8mb4". Si ocurre un error, detiene la ejecución con un mensaje.
 * - getConexion(): Devuelve el objeto mysqli que representa la conexión activa.
 * - cerrarConexion(): Cierra la conexión activa para liberar recursos.
 * 
 * Notas:
 * - Las credenciales de la base de datos se cargan desde un archivo .env para mejorar la seguridad.
 * - Se recomienda manejar errores de conexión de forma más robusta, como registrarlos en un archivo de log.
 * - Puede implementarse un patrón Singleton para garantizar una única instancia de la conexión.
 * 
 * Ejemplo de uso:
 * ```php
 * $db = new Conexion();
 * $conexion = $db->getConexion();
 * // Realizar operaciones con $conexion
 * $db->cerrarConexion();
 * ```
 */
class Conexion
{
    private $host;
    private $usuario;
    private $password;
    private $baseDatos;
    private $conexion;

    public function __construct()
    {
        // Cargar variables del archivo .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Ruta al .env
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->usuario = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->baseDatos = $_ENV['DB_NAME'];

        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->baseDatos);

        if ($this->conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $this->conexion->connect_error);
        }

        $this->conexion->set_charset("utf8mb4");
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}

// Ejemplo de uso
// $db = new Conexion();
// $conexion = $db->getConexion();