USE ifolha;
SET NAMES utf8mb4;

-- 1. Cria um usuário padrão para ser o Autor
INSERT INTO usuarios (id, nome, email, senha, tipo) 
VALUES (1, 'Redação IFolha', 'redacao@ifmt.edu.br', '123456', 'admin')
ON DUPLICATE KEY UPDATE nome=VALUES(nome), email=VALUES(email);

-- 2. Insere as 3 notícias na tabela 'posts' (categoria_id = 1 é 'Notícias')
INSERT INTO posts (id, titulo, resumo, conteudo, categoria_id, autor_id, criado_em) VALUES 
(
  1,
  'JIF Centro-Oeste encerra edição 2026 e define campeões das modalidades coletivas',
  'Os Jogos dos Institutos Federais (JIF) Centro-Oeste 2026 fecharam com chave de ouro nesta sexta-feira (25) lá no IFMT Campus Barra do Garças! Foram cinco dias de pura adrenalina, suor e muita parceria...',
  'Os Jogos dos Institutos Federais (JIF) Centro-Oeste 2026 fecharam com chave de ouro nesta sexta-feira (25) lá no IFMT Campus Barra do Garças!\n\nForam cinco dias de pura adrenalina, suor e muita parceria, reunindo 621 estudantes-atletas e 81 servidores em uma integração bonita de ver. O último dia de competições foi aquele teste para o coração, com as grandes finais dos esportes coletivos e a entrega das medalhas que carimbaram o passaporte dos campeões para a fase nacional.\n\nDurante a semana, a galera do IFMT, IFG, IFGoiano, IFB e IFMS deu o sangue nas quadras, pistas e piscinas. Teve disputa no atletismo, natação, judô, xadrez, tênis de mesa, futebol de campo, basquete, handebol, futsal, voleibol e vôlei de praia.\n\nQuem subiu no lugar mais alto do pódio já pode começar a arrumar as malas: os primeiros colocados garantiram vaga direto na Etapa Nacional dos JIF, que vai rolar entre 19 e 23 de outubro de 2026, em Goiânia (GO).',
  1, 1, '2026-09-25 10:00:00'
),
(
  2,
  '11º Encontro de Egressos e Comunidade Histórica',
  'O sábado, 19 de setembro, foi marcado pela nostalgia e reencontros felizes! O IFMT Campus Cáceres – Prof. Olegário Baldo realizou o seu esperado 11º Encontro de Egressos e Comunidade Histórica...',
  'O sábado, 19 de setembro, foi marcado pela nostalgia e reencontros felizes!\n\nO IFMT Campus Cáceres – Prof. Olegário Baldo realizou o seu esperado 11º Encontro de Egressos e Comunidade Histórica. O evento foi planejado nos mínimos detalhes com um objetivo muito especial: reunir ex-alunos, servidores e todo mundo que fez ou faz parte dessa trajetória para um dia inesquecível de reencontros, celebração e muita troca de histórias.\n\nA programação começou cedinho, a partir das 7h, com as atividades rolando no próprio Campus Cáceres. Depois de aproveitar a manhã inteira matando a saudade dos corredores da instituição, os participantes seguiram para o Sindicato Rural de Cáceres, onde rolou um almoço caprichado e muita descontração a partir das 12h30.',
  1, 1, '2026-09-19 08:00:00'
),
(
  3,
  '5ª Codir (Reunião Ordinária do Colégio de Dirigentes) do IFMT',
  'O Campus Cáceres do IFMT ficou movimentado no último dia 10 de setembro! A unidade sediou a 5ª Reunião Ordinária do Colégio de Dirigentes (Codir) do IFMT...',
  'O Campus Cáceres do IFMT ficou movimentado no último dia 10 de setembro!\n\nA unidade sediou a 5ª Reunião Ordinária do Colégio de Dirigentes (Codir) do IFMT, reunindo toda a chefia no auditório para alinhar os rumos da gestão e o desenvolvimento da instituição.\n\nPara quem não conhece, o Codir é aquele braço direito da Reitoria na hora de tomar decisões importantes. O time é de peso, formado pelo reitor, pró-reitores e os diretores-gerais de todos os campi e campi avançados.\n\nNesse encontro, a galera debateu e definiu muita coisa séria: desde a grana (execução orçamentária e planejamento) até o que rola no dia a dia, como ensino, pesquisa, extensão, inovação, calendário de aulas e parcerias do Instituto.',
  1, 1, '2026-09-10 09:00:00'
)
ON DUPLICATE KEY UPDATE 
  titulo=VALUES(titulo), 
  resumo=VALUES(resumo), 
  conteudo=VALUES(conteudo), 
  categoria_id=VALUES(categoria_id), 
  autor_id=VALUES(autor_id), 
  criado_em=VALUES(criado_em);