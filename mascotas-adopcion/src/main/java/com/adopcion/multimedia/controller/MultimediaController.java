package com.adopcion.multimedia.controller;

import com.adopcion.multimedia.model.Multimedia;
import com.adopcion.multimedia.service.MultimediaService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.multipart.MultipartFile;

import java.util.List;

/**
 * Controlador REST para gestionar las operaciones del módulo Multimedia.
 * Expone los endpoints para subir, listar y eliminar archivos.
 */
@RestController
@RequestMapping("/api/v1/multimedia") // URL base para todos los endpoints de este controlador
public class MultimediaController {

    private final MultimediaService multimediaService;

    // Inyección de dependencias del servicio
    public MultimediaController(MultimediaService multimediaService) {
        this.multimediaService = multimediaService;
    }

    /**
     * Endpoint para subir un archivo y asociarlo a un Post existente.
     * Escucha peticiones POST en /api/v1/multimedia/posts/{postId}
     *
     * @param postId El ID del post al que se adjunta el archivo.
     * @param archivo El archivo enviado en la petición (multipart/form-data).
     * @return ResponseEntity con la metadata del archivo guardado y un estado 201 CREATED.
     */
    @PostMapping("/posts/{postId}")
    public ResponseEntity<Multimedia> subirArchivo(@PathVariable Long postId, @RequestParam("file") MultipartFile archivo) {
        Multimedia archivoGuardado = multimediaService.guardarArchivo(postId, archivo);
        return ResponseEntity.status(HttpStatus.CREATED).body(archivoGuardado);
    }

    /**
     * Endpoint para obtener todos los archivos multimedia de un Post específico.
     * Escucha peticiones GET en /api/v1/multimedia/posts/{postId}
     *
     * @param postId El ID del post.
     * @return ResponseEntity con la lista de archivos y un estado 200 OK.
     */
    @GetMapping("/posts/{postId}")
    public ResponseEntity<List<Multimedia>> listarArchivosPorPost(@PathVariable Long postId) {
        List<Multimedia> archivos = multimediaService.obtenerMultimediaPorPost(postId);
        return ResponseEntity.ok(archivos);
    }

    /**
     * Endpoint para eliminar un archivo multimedia por su ID.
     * Escucha peticiones DELETE en /api/v1/multimedia/{multimediaId}
     *
     * @param multimediaId El ID del archivo a eliminar.
     * @return ResponseEntity sin contenido y con estado 204 NO CONTENT.
     */
    @DeleteMapping("/{multimediaId}")
    public ResponseEntity<Void> eliminarArchivo(@PathVariable Long multimediaId) {
        multimediaService.eliminarArchivo(multimediaId);
        return ResponseEntity.noContent().build();
    }
}