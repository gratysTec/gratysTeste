<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Post extends Model
{
    private string $baseSelect = "
        SELECT 
            p.*,
            c.nome AS categoria_nome,
            u.nome AS autor_nome,
            e.data_evento,
            e.horario AS horario_evento,
            e.local AS local_evento,
            (SELECT COUNT(*) FROM curtidas WHERE post_id = p.id) AS total_curtidas,
            (SELECT COUNT(*) FROM visualizacoes WHERE post_id = p.id) AS total_visualizacoes
        FROM posts p
        JOIN categorias c ON p.categoria_id = c.id
        LEFT JOIN usuarios u ON p.autor_id = u.id
        LEFT JOIN eventos e ON e.post_id = p.id
    ";

    /**
     * Retorna todos os posts publicados
     */
    public function getAll(int $limit = 10): array
    {
        $sql = $this->baseSelect . " WHERE p.publicado = TRUE ORDER BY p.criado_em DESC LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retorna o post em destaque ou o mais recente
     */
    public function getFeatured(): ?array
    {
        $sql = $this->baseSelect . " WHERE p.publicado = TRUE ORDER BY p.criado_em DESC LIMIT 1";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Retorna post por ID
     */
    public function getById(int $id): ?array
    {
        $sql = $this->baseSelect . " WHERE p.id = :id AND p.publicado = TRUE LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Retorna posts por categoria (nome ou ID)
     */
    public function getByCategoria(string|int $categoria, int $limit = 20): array
    {
        if (is_numeric($categoria)) {
            $sql = $this->baseSelect . " 
                WHERE p.categoria_id = :categoria 
                  AND p.publicado = TRUE 
                ORDER BY p.criado_em DESC 
                LIMIT :limit
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':categoria', (int)$categoria, PDO::PARAM_INT);
        } else {
            $sql = $this->baseSelect . " 
                WHERE (c.nome LIKE :categoriaLike OR LOWER(c.nome) = LOWER(:exactNome)) 
                  AND p.publicado = TRUE 
                ORDER BY p.criado_em DESC 
                LIMIT :limit
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':categoriaLike', '%' . trim($categoria) . '%');
            $stmt->bindValue(':exactNome', $categoria);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Incrementa visualização do post
     */
    public function addVisualizacao(int $postId, ?int $usuarioId = null): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO visualizacoes (post_id, usuario_id) 
            VALUES (:post_id, :usuario_id)
        ");
        $stmt->execute([
            'post_id'    => $postId,
            'usuario_id' => $usuarioId
        ]);
    }

    /**
     * Alterna curtida (adiciona se não existir)
     */
    public function toggleCurtida(int $postId, ?int $usuarioId = null): array
    {
        if ($usuarioId !== null) {
            $stmt = $this->db->prepare("SELECT id FROM curtidas WHERE post_id = :post_id AND usuario_id = :usuario_id");
            $stmt->execute(['post_id' => $postId, 'usuario_id' => $usuarioId]);
            $existing = $stmt->fetch();

            if ($existing) {
                $del = $this->db->prepare("DELETE FROM curtidas WHERE id = :id");
                $del->execute(['id' => $existing['id']]);
                $liked = false;
            } else {
                $ins = $this->db->prepare("INSERT INTO curtidas (post_id, usuario_id) VALUES (:post_id, :usuario_id)");
                $ins->execute(['post_id' => $postId, 'usuario_id' => $usuarioId]);
                $liked = true;
            }
        } else {
            // Visitante sem login: registra curtida anônima
            $ins = $this->db->prepare("INSERT INTO curtidas (post_id, usuario_id) VALUES (:post_id, NULL)");
            $ins->execute(['post_id' => $postId]);
            $liked = true;
        }

        // Obtém contagem atualizada
        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM curtidas WHERE post_id = :post_id");
        $countStmt->execute(['post_id' => $postId]);
        $total = (int) $countStmt->fetchColumn();

        return [
            'liked' => $liked,
            'total' => $total
        ];
    }

    /**
     * Retorna todas as publicações (incluindo rascunhos) para o painel admin
     */
    public function getAllAdmin(): array
    {
        $sql = $this->baseSelect . " ORDER BY p.criado_em DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Cria uma nova publicação
     */
    public function create(array $data): int
    {
        $sql = "INSERT INTO posts (titulo, resumo, conteudo, categoria_id, autor_id, publicado) 
                VALUES (:titulo, :resumo, :conteudo, :categoria_id, :autor_id, :publicado)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'titulo'       => $data['titulo'],
            'resumo'       => $data['resumo'] ?? null,
            'conteudo'     => $data['conteudo'],
            'categoria_id' => (int) $data['categoria_id'],
            'autor_id'     => !empty($data['autor_id']) ? (int) $data['autor_id'] : null,
            'publicado'    => !empty($data['publicado']) ? 1 : 0
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Atualiza uma publicação existente
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE posts 
                SET titulo = :titulo, 
                    resumo = :resumo, 
                    conteudo = :conteudo, 
                    categoria_id = :categoria_id, 
                    publicado = :publicado 
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id'           => $id,
            'titulo'       => $data['titulo'],
            'resumo'       => $data['resumo'] ?? null,
            'conteudo'     => $data['conteudo'],
            'categoria_id' => (int) $data['categoria_id'],
            'publicado'    => !empty($data['publicado']) ? 1 : 0
        ]);
    }

    /**
     * Exclui uma publicação
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Salva ou atualiza detalhes do evento
     */
    public function saveEvento(int $postId, ?string $dataEvento, ?string $horario = null, ?string $local = null): void
    {
        if (!empty($dataEvento)) {
            $sql = "INSERT INTO eventos (post_id, data_evento, horario, local)
                    VALUES (:post_id, :data_evento, :horario, :local)
                    ON DUPLICATE KEY UPDATE 
                        data_evento = VALUES(data_evento),
                        horario     = VALUES(horario),
                        local       = VALUES(local)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'post_id'     => $postId,
                'data_evento' => $dataEvento,
                'horario'     => !empty($horario) ? $horario : null,
                'local'       => !empty($local) ? $local : null,
            ]);
        } else {
            // Se o usuário removeu a data do evento, remove registro da tabela
            $stmt = $this->db->prepare("DELETE FROM eventos WHERE post_id = :post_id");
            $stmt->execute(['post_id' => $postId]);
        }
    }
}
