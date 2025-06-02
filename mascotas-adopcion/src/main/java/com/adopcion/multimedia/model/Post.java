package com.adopcion.multimedia.model;

import java.time.LocalDateTime;
import java.util.ArrayList;
import java.util.List;
import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Builder;
import lombok.Data;
import lombok.NoArgsConstructor;

/**
 * Entidad que representa una publicación (Post) en el sistema de adopción.
 * Puede ser sobre una mascota en adopción, un evento, etc.
 */
@Entity
@Table(name = "posts") // Es buena práctica nombrar las tablas en plural

@Data
@Builder
@NoArgsConstructor
@AllArgsConstructor
public class Post {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(nullable = false, length = 150)
    private String titulo;

    @Lob // Large Object: indica que puede ser un texto largo.
    @Column(nullable = false, columnDefinition = "TEXT")
    private String descripcion;

    @Column(nullable = false)
    private LocalDateTime fechaPublicacion;
    
    // Aquí podrías tener una relación con una entidad Mascota, Usuario, etc.
    // @ManyToOne
    // @JoinColumn(name = "mascota_id")
    // private Mascota mascota;

    // --- Relación Inversa con Multimedia ---
    @OneToMany(
        mappedBy = "post", // ¡MUY IMPORTANTE!
        cascade = CascadeType.ALL,
        orphanRemoval = true,
        fetch = FetchType.LAZY
    )
    private List<Multimedia> multimedia = new ArrayList<>();
}