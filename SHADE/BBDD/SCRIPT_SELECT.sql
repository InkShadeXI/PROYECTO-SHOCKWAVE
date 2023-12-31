-- CONSULTA GENÉRICA DE USUARIOS:
SELECT * FROM USUARIO;

-- CONSULTA ESPECÍFICA:
SELECT * FROM USUARIO WHERE NOMBRE_USUARIO = "SHADE";

-- CONSULTA AMISTAD (MEDIANTE SUBCONSULTA ID)
SELECT DISTINCT E1.NOMBRE_USUARIO, E2.NOMBRE_USUARIO FROM AMISTAD M1 
JOIN USUARIO E1 ON E1.ID_USUARIO = M1.ID_USUARIO_1
JOIN USUARIO E2 ON E2.ID_USUARIO = M1.ID_USUARIO_2
WHERE E1.NOMBRE_USUARIO = (
    SELECT NOMBRE_USUARIO FROM USUARIO
    WHERE ID_USUARIO = 1
);

-- CONSULTA AMISTAD MEDIANTE NOMBRE
SELECT DISTINCT E1.NOMBRE_USUARIO, E2.NOMBRE_USUARIO FROM AMISTAD M1 
JOIN USUARIO E1 ON E1.ID_USUARIO = M1.ID_USUARIO_1
JOIN USUARIO E2 ON E2.ID_USUARIO = M1.ID_USUARIO_2
WHERE E1.NOMBRE_USUARIO = "SHADE";

-- CONSULTA PARA SACAR EL NOMBRE A TRAVES DEL ID
SELECT NOMBRE_USUARIO FROM USUARIO WHERE ID_USUARIO = 1;

-- CONSULTA PARA SACAR EL ID A TRAVES DEL NOMBRE
SELECT ID_USUARIO FROM USUARIO WHERE NOMBRE_USUARIO = "SHADE";

-- CONSULTA PARA SACAR LOS POST Y SU RESPECTIVO USUARIO A TRAVÉS DEL ID
SELECT NOMBRE_USUARIO E1, TEXTO_POST T1 FROM POST_USUARIO WHERE ID_USUARIO_POST = 1;

-- CONSULTA PARA SACAR EL POST Y LOS COMENTARIOS RECIBIDOS EN ESE POST, SE PUEDE VER EL NOMBRE DEL AUTOR DEL POST Y EL NOMBRE DE QUIEN COMENTÓ (A TRAVÉS DE ID)
SELECT E1.NOMBRE_USUARIO AS "USUARIO PUBLICÓ", P1.TEXTO_POST AS "POST", E2.NOMBRE_USUARIO AS "HA COMENTADO", C1.TEXTO_COMENTARIO AS "TEXTO"
FROM POST_USUARIO P1
JOIN COMENTARIO C1 ON C1.ID_COMENTARIO_POST = P1.ID_POST 
JOIN USUARIO E1 ON P1.ID_USUARIO_POST = E1.ID_USUARIO
JOIN USUARIO E2 ON C1.ID_COMENTARIO_USUARIO = E2.ID_USUARIO
WHERE P1.ID_POST = 2;

-- CONSULTA PARA SACAR EL POST Y LOS COMENTARIOS RECIBIDOS EN ESE POST, SE PUEDE VER EL NOMBRE DEL AUTOR DEL POST Y EL NOMBRE DE QUIEN COMENTÓ
-- (A TRAVÉS DEL NOMBRE DEL AUTOR DEL POST)
SELECT E1.NOMBRE_USUARIO AS "USUARIO PUBLICÓ", P1.TEXTO_POST AS "POST", E2.NOMBRE_USUARIO AS "HA COMENTADO", C1.TEXTO_COMENTARIO AS "TEXTO"
FROM POST_USUARIO P1
JOIN COMENTARIO C1 ON C1.ID_COMENTARIO_POST = P1.ID_POST 
JOIN USUARIO E1 ON P1.ID_USUARIO_POST = E1.ID_USUARIO
JOIN USUARIO E2 ON C1.ID_COMENTARIO_USUARIO = E2.ID_USUARIO
WHERE E1.NOMBRE_USUARIO = "JARABA";