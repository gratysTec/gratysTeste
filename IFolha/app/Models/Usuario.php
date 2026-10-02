<?php
namespace App\Models;

use App\Core\Model;

class Usuario extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT id, nome, email, tipo, criado_em FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        // Suporta hash bcrypt ou senha em texto simples (para os dados iniciais do seed)
        $valid = password_verify($password, $user['senha']) || ($user['senha'] === $password);

        if ($valid) {
            unset($user['senha']);
            return $user;
        }

        return null;
    }
}
