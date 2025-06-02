package com.adopcion.multimedia.service;

import com.adopcion.multimedia.exception.ResourceNotFoundException;
import com.adopcion.multimedia.model.Multimedia;
import com.adopcion.multimedia.model.Post;
import com.adopcion.multimedia.repository.MultimediaRepository;
import com.adopcion.multimedia.repository.PostRepository;
import com.adopcion.multimedia.service.storage.FileStorageService;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.time.LocalDateTime;
import java.util.List;

/**
 * Servicio que contiene la lógica de negocio para gestionar los archivos multimedia.
 * Orquesta las operaciones entre el almacenamiento físico y la base de datos.
 */
@Service
public class MultimediaService {

    private final MultimediaRepository multimediaRepository;
    private final PostRepository postRepository; // Asumimos que este repositorio existe
    private final FileStorageService fileStorageService;

    /**
     * Inyección de dependencias por constructor. Spring se encarga de proveer
     * las instancias de los repositorios y otros servicios.
     */
    public MultimediaService(MultimediaRepository multimediaRepository, 
                             PostRepository postRepository, 
                             FileStorageService fileStorageService) {
        this.multimediaRepository = multimediaRepository;
        this.postRepository = postRepository;
        this.fileStorageService = fileStorageService;
    }

    /**
     * Procesa la subida de un archivo, lo guarda físicamente y persiste sus metadatos.
     *
     * @param postId El ID del Post al que se asociará el archivo.
     * @param archivo El archivo subido desde la petición web (MultipartFile).
     * @return La entidad Multimedia que ha sido guardada.
     */
    public Multimedia guardarArchivo(Long postId, MultipartFile archivo) {
        // 1. Verificar que el Post exista
        Post post = postRepository.findById(postId)
                .orElseThrow(() -> new ResourceNotFoundException("No se encontró el Post con id: " + postId));

        // 2. Guardar el archivo físico usando el servicio de almacenamiento
        String urlDelArchivo = fileStorageService.guardarArchivo(archivo);

        // 3. Crear la entidad Multimedia con sus metadatos
        Multimedia multimedia = Multimedia.builder()
                .nombreArchivo(archivo.getOriginalFilename())
                .url(urlDelArchivo)
                .tipoMime(archivo.getContentType())
                .tamanio(archivo.getSize())
                .fechaSubida(LocalDateTime.now())
                .post(post) // 4. Asociar con el Post encontrado
                .build();

        // 5. Guardar la entidad en la base de datos y retornarla
        return multimediaRepository.save(multimedia);
    }
    
    /**
     * Elimina un archivo multimedia tanto del almacenamiento físico como de la base de datos.
     *
     * @param multimediaId El ID del archivo multimedia a eliminar.
     */
    public void eliminarArchivo(Long multimediaId) {
        // 1. Buscar la entidad en la base de datos
        Multimedia multimedia = multimediaRepository.findById(multimediaId)
                .orElseThrow(() -> new ResourceNotFoundException("No se encontró el archivo multimedia con id: " + multimediaId));
        
        // 2. Eliminar el archivo físico
        fileStorageService.eliminarArchivo(multimedia.getUrl());
        
        // 3. Eliminar el registro de la base de datos
        multimediaRepository.delete(multimedia);
    }
    
    /**
     * Obtiene todos los metadatos de los archivos asociados a un Post.
     * @param postId El ID del Post.
     * @return Una lista de entidades Multimedia.
     */
    public List<Multimedia> obtenerMultimediaPorPost(Long postId) {
        // Simplemente delegamos la llamada al método que creamos en el repositorio
        return multimediaRepository.findByPostId(postId);
    }
}