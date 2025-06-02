package com.adopcion.multimedia.repository;

import com.adopcion.multimedia.model.Multimedia;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

/**
 * Repositorio para la entidad Multimedia.
 * Extiende JpaRepository para obtener operaciones CRUD básicas de forma automática.
 * Spring Data JPA implementará esta interfaz en tiempo de ejecución.
 */
@Repository
public interface MultimediaRepository extends JpaRepository<Multimedia, Long> {

    // --- MÉTODOS DE CONSULTA PERSONALIZADOS (Query Methods) ---
    
    /**
     * Busca todos los archivos multimedia asociados a un ID de Post específico.
     * Spring Data JPA automáticamente generará la consulta SQL a partir del
     * nombre de este método.
     *
     * Equivalente a: "SELECT * FROM multimedia WHERE post_id = ?"
     *
     * @param postId El ID del Post por el cual filtrar.
     * @return Una lista de objetos Multimedia.
     */
    List<Multimedia> findByPostId(Long postId);

}