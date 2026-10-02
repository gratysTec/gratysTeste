CREATE DATABASE IF NOT EXISTS ifolha CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ifolha;
SET NAMES utf8mb4;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin', 'aluno') DEFAULT 'aluno',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO categorias (nome) VALUES
('Notícias'),
('Eventos'),
('Palestras'),
('Editais'),
('Regras');

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(200) NOT NULL,

    resumo TEXT,

    conteudo TEXT NOT NULL,

    categoria_id INT NOT NULL,

    autor_id INT,

    imagem VARCHAR(255),

    publicado BOOLEAN DEFAULT TRUE,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (categoria_id)
        REFERENCES categorias(id),

    FOREIGN KEY (autor_id)
        REFERENCES usuarios(id)
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,

    post_id INT NOT NULL UNIQUE,

    data_evento DATE NOT NULL,

    horario TIME,

    local VARCHAR(150),

    FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE
);

CREATE TABLE curtidas (
    id INT AUTO_INCREMENT PRIMARY KEY,

    post_id INT NOT NULL,

    usuario_id INT,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);

SELECT COUNT(*)
FROM curtidas
WHERE post_id = 1;

CREATE TABLE visualizacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    post_id INT NOT NULL,

    usuario_id INT,

    visualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (post_id)
        REFERENCES posts(id)
        ON DELETE CASCADE,

    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE SET NULL
);

SELECT COUNT(*)
FROM visualizacoes
WHERE post_id = 1;
