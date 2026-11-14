USE projeto;

-- Colunas usadas para sessão persistente e controle de acesso.
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS active TINYINT(1) NOT NULL DEFAULT 1 AFTER phone_number,
    ADD COLUMN IF NOT EXISTS last_login_at DATETIME NULL AFTER active;

-- Administradores fixos do sistema.
-- As senhas abaixo estão armazenadas com password_hash(PASSWORD_DEFAULT).
-- Se os e-mails já existirem, os dados de acesso são atualizados.

INSERT INTO users (
    type_id,
    specialty_id,
    name,
    email,
    password,
    city,
    state,
    phone_number
) VALUES
(
    1,
    NULL,
    'Nat',
    'nat@gmail.com',
    '$2y$12$0mNMsTZZAJCFbLTiLu3Xn.KiRYv5fwAey.sLKaSFoNyoH.qirFCMm',
    'Charqueadas',
    'RS',
    '00000000000'
),
(
    1,
    NULL,
    'Lav',
    'lav@gmail.com',
    '$2y$12$zvUrAStq2pdyirCNFKm93uLugtSS.JqrLumEOlv0AvwKLEc8Plakm',
    'Charqueadas',
    'RS',
    '00000000000'
)
ON DUPLICATE KEY UPDATE
    type_id = VALUES(type_id),
    specialty_id = VALUES(specialty_id),
    name = VALUES(name),
    password = VALUES(password),
    city = VALUES(city),
    state = VALUES(state),
    phone_number = VALUES(phone_number);

SELECT id, type_id, name, email, city, state, phone_number, active, last_login_at
FROM users
WHERE email IN ('nat@gmail.com', 'lav@gmail.com');
