USE projeto;

-- Adiciona a coluna active somente se ela ainda não existir.
SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = 'projeto'
       AND TABLE_NAME = 'users'
       AND COLUMN_NAME = 'active') = 0,
    'ALTER TABLE users ADD COLUMN active TINYINT(1) NOT NULL DEFAULT 1 AFTER phone_number',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Adiciona a coluna last_login_at somente se ela ainda não existir.
SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = 'projeto'
       AND TABLE_NAME = 'users'
       AND COLUMN_NAME = 'last_login_at') = 0,
    'ALTER TABLE users ADD COLUMN last_login_at DATETIME NULL AFTER active',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Garante que usuários que já existiam fiquem ativos.
UPDATE users SET active = 1 WHERE active IS NULL;

-- Conferência final.
SELECT id, name, email, type_id, active, last_login_at
FROM users
ORDER BY id;

-- Controle real das solicitações de fotógrafos.
-- 0 = aguardando aprovação | 1 = aprovado | 2 = recusado
SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = 'projeto' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'approval_status') = 0,
    'ALTER TABLE users ADD COLUMN approval_status TINYINT NOT NULL DEFAULT 1 AFTER active',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Guarda quando o cadastro foi criado.
SET @sql = IF(
    (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
     WHERE TABLE_SCHEMA = 'projeto' AND TABLE_NAME = 'users' AND COLUMN_NAME = 'created_at') = 0,
    'ALTER TABLE users ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER last_login_at',
    'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
