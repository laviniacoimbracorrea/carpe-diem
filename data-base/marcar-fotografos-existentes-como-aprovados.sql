USE projeto;

/*
  IMPORTANTE:
  Execute este arquivo UMA VEZ, antes de novos fotógrafos se cadastrarem.

  Os fotógrafos que já existiam no banco antes da implantação do sistema
  de aprovação são considerados fotógrafos já aprovados.

  Novos fotógrafos continuam sendo cadastrados pelo PHP com:
  approval_status = 0
  e só entram como ativos depois da aprovação do administrador.
*/

UPDATE users
SET approval_status = 1,
    active = 1
WHERE type_id = 2;

SELECT
    id,
    name,
    email,
    type_id,
    active,
    approval_status,
    created_at,
    last_login_at
FROM users
WHERE type_id = 2
ORDER BY id;
