<?php

//function que obtiene los datos de todos los partidos para realizar la tabla de posiciones.
function obtenerTablaPosiciones($conexion) {
    $sql = "
        SELECT 
            e.id,
            e.nombre,
            e.escudo,
            COALESCE(SUM(CASE WHEN e.id IN (p.equipo_local, p.equipo_visitante) THEN 1 ELSE 0 END), 0) AS PJ,
            COALESCE(SUM(CASE 
                WHEN (e.id = p.equipo_local AND p.goles_local > p.goles_visitante) OR 
                     (e.id = p.equipo_visitante AND p.goles_visitante > p.goles_local)
                THEN 1 ELSE 0 END), 0) AS PG,
            COALESCE(SUM(CASE WHEN p.goles_local = p.goles_visitante AND e.id IN (p.equipo_local, p.equipo_visitante) THEN 1 ELSE 0 END), 0) AS PE,
            COALESCE(SUM(CASE 
                WHEN (e.id = p.equipo_local AND p.goles_local < p.goles_visitante) OR 
                     (e.id = p.equipo_visitante AND p.goles_visitante < p.goles_local)
                THEN 1 ELSE 0 END), 0) AS PP,
            COALESCE(SUM(CASE 
                WHEN e.id = p.equipo_local THEN p.goles_local
                WHEN e.id = p.equipo_visitante THEN p.goles_visitante
                ELSE 0 END), 0) AS GF,
            COALESCE(SUM(CASE 
                WHEN e.id = p.equipo_local THEN p.goles_visitante
                WHEN e.id = p.equipo_visitante THEN p.goles_local
                ELSE 0 END), 0) AS GC,
            COALESCE(SUM(CASE 
                WHEN e.id = p.equipo_local THEN p.goles_local - p.goles_visitante
                WHEN e.id = p.equipo_visitante THEN p.goles_visitante - p.goles_local
                ELSE 0 END), 0) AS DG,
            COALESCE(SUM(CASE 
                WHEN (e.id = p.equipo_local AND p.goles_local > p.goles_visitante) OR 
                     (e.id = p.equipo_visitante AND p.goles_visitante > p.goles_local) THEN 3
                WHEN p.goles_local = p.goles_visitante AND e.id IN (p.equipo_local, p.equipo_visitante) THEN 1
                ELSE 0 END), 0) AS PTS
        FROM 
            equipos e
        LEFT JOIN 
            partidos p ON e.id = p.equipo_local OR e.id = p.equipo_visitante
        GROUP BY 
            e.id
        ORDER BY 
            PTS DESC, DG DESC, GF DESC
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
