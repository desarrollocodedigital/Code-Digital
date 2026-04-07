<?php
/**
 * Modelo: Plantillas
 * Gestiona CRUD de plantillas de correo.
 */
include_once __DIR__ . '/../config/db.php';

function getPlantillas() {
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM plantillas_email ORDER BY titulo ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

function getPlantillaById($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT * FROM plantillas_email WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }
}

function savePlantilla($data) {
    global $pdo;
    try {
        if (!empty($data['id'])) {
            $sql = "UPDATE plantillas_email SET titulo = :titulo, asunto = :asunto, cuerpo = :cuerpo WHERE id = :id";
        } else {
            $sql = "INSERT INTO plantillas_email (titulo, asunto, cuerpo) VALUES (:titulo, :asunto, :cuerpo)";
        }
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($data);
    } catch (PDOException $e) {
        return false;
    }
}

function deletePlantilla($id) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("DELETE FROM plantillas_email WHERE id = ?");
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}
?>
