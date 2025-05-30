package com.adopcion.multimedia.model;

import java.time.LocalDateTime;
import jakarta.persistence.*; 
import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;

/**
 * Entidad que representa un archivo multimedia asociado a un Post.
 * Contiene metadatos sobre el archivo y su relación con otras entidades.
 */
@Entity
@Table(name = "multimedia") // Define el nombre de la tabla en la base de datos

// Anotaciones de Lombok para un código limpio
@Data // Genera getters, setters, toString, equals y hashCode
@Builder // Implementa el patrón Builder para crear objetos de forma fluida
@NoArgsConstructor // Genera un constructor sin argumentos (requerido por JPA)
@AllArgsConstructor // Genera un constructor con todos los argumentos
public class Multimedia {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY) // El ID se autogenera en la BD
    private Long id;

    @Column(nullable = false)
    private String nombreArchivo; // ej: "lindo_perrito.jpg"

    @Column(nullable = false)
    private String url;           // La URL pública o la ruta donde se guardó

    @Column(nullable = false)
    private String tipoMime;      // ej: "image/jpeg", "video/mp4"

    private long tamanio;         // Tamaño en bytes

    @Enumerated(EnumType.STRING) // Guarda el nombre del enum ("IMAGEN") en la BD, no el índice numérico
    @Column(nullable = false)
    private TipoRecurso tipoRecurso;

    private String textoAlternativo; // Importante para accesibilidad (SEO)

    @Column(nullable = false)
    private LocalDateTime fechaSubida;

    // --- Relación con la entidad Post ---
    @ManyToOne(fetch = FetchType.LAZY) // Muchos archivos multimedia pueden pertenecer a Un Post.
    @JoinColumn(name = "post_id", nullable = false) // Define la columna de la clave foránea.
    private Post post;
}