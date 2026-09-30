<?php

namespace Model;

class ActiveRecord
{

  // Base DE DATOS
  protected static $db;
  protected static $table = '';
  protected static $dbColumns = [];

  // Alertas y Mensajes
  protected static $alerts = [];

  // Definir la conexión a la BD - includes/database.php
  public static function setDB($database)
  {
    self::$db = $database;
  }

  public static function setAlert($tipo, $mensaje)
  {
    static::$alerts[$tipo][] = $mensaje;
  }
  // Validación
  public static function getAlerts()
  {
    return static::$alerts;
  }

  public function validate()
  {
    static::$alerts = [];
    return static::$alerts;
  }

  // Registros - CRUD
  public function save()
  {
    $result = '';
    if (!is_null($this->id)) {
      // actualizar
      $result = $this->update();
    } else {
      // Creando un nuevo registro
      $result = $this->create();
    }
    return $result;
  }

  public static function all()
  {
    $query = "SELECT * FROM " . static::$table;
    $result = self::querySQL($query);
    return $result;
  }

  // Busca un registro por su id
  public static function find($id)
  {
    $query = "SELECT * FROM " . static::$table  . " WHERE id = $id";
    $result = self::querySQL($query);
    return array_shift($result);
  }

  // Obtener Registro
  public static function get($limit)
  {
    $query = "SELECT * FROM " . static::$table . " LIMIT $limit";
    $result = self::querySQL($query);
    return array_shift($result);
  }

  // Busqueda Where con Columna 
  public static function where($column, $value, $many = false)
  {
    $query = "SELECT * FROM " . static::$table . " WHERE $column = '" . self::$db->escape_string($value) . "'";
    $result = self::querySQL($query);
    if ($many) {
      return $result;
    } else {
      return array_shift($result);
    }
  }

  // SQL para Consultas Avanzadas.
  public static function SQL($query)
  {
    $result = self::querySQL($query);
    return $result;
  }

  // crea un nuevo registro
  public function create()
  {
    // Sanitizar los datos
    $data = $this->sanitizeData();

    // Insertar en la base de datos
    $query = " INSERT INTO " . static::$table . " ( ";
    $query .= join(', ', array_keys($data));
    $query .= " ) VALUES ( '";
    $query .= join("', '", array_values($data));
    $query .= "' ) ";

    // Resultado de la consulta
    $result = self::$db->query($query);

    return [
      'result' =>  $result,
      'id' => self::$db->insert_id
    ];
  }

  public function update()
  {
    // Sanitizar los datos
    $data = $this->sanitizeData();
    // Iterar para ir agregando cada campo de la BD
    $values = [];
    foreach ($data as $key => $value) {
      if ($value === null) {
        $values[] = "$key=NULL";
      } else {
        $values[] = "{$key}='{$value}'";
      }
    }

    $query = "UPDATE " . static::$table . " SET ";
    $query .=  join(', ', $values);
    $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
    $query .= " LIMIT 1 ";

    $result = self::$db->query($query);
    return $result;
  }

  // Eliminar un registro - Toma el ID de Active Record
  public function delete()
  {
    $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
    $result = self::$db->query($query);
    return $result;
  }

  public static function querySQL($query)
  {
    // Consultar la base de datos
    $result = self::$db->query($query);

    // Iterar los resultados
    $array = [];
    while ($row = $result->fetch_assoc()) {
      $array[] = static::createObject($row);
    }

    // liberar la memoria
    $result->free();

    // retornar los resultados
    return $array;
  }

  protected static function createObject($row)
  {
    $object = new static;

    foreach ($row as $key => $value) {
      if (property_exists($object, $key)) {
        $object->$key = $value;
      }
    }

    return $object;
  }



  // Identificar y unir los atributos de la BD
  public function data()
  {
    $data = [];
    foreach (static::$dbColumns as $column) {
      if ($column === 'id') continue;
      $data[$column] = $this->$column;
    }
    return $data;
  }

  public function sanitizeData()
  {
    $data = $this->data();
    $sanitized = [];
    foreach ($data as $key => $value) {
      if ($value === null) {
        $sanitized[$key] = NULL;
      } else {
        $sanitized[$key] = self::$db->escape_string($value);
      }
    }
    return $sanitized;
  }

  public function sync($args = [])
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }
}
