<?php
namespace App\Models;

use App\Core\Model;

class Categoria extends Model
{
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function getByNome(string $nome): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE LOWER(nome) = LOWER(:nome)");
        $stmt->execute(['nome' => $nome]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
}
