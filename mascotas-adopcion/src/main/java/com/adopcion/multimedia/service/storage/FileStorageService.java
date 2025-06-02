package com.adopcion.multimedia.service.storage;

import org.springframework.web.multipart.MultipartFile;

/**
 * Interfaz que define el contrato para las operaciones de almacenamiento de archivos.
 * Esto nos permite cambiar fácilmente la implementación (ej. de local a la nube)
 * sin alterar el resto del código.
 */
public interface FileStorageService {

    /**
     * Guarda un archivo y devuelve la ruta o URL para acceder a él.
     */
    String guardarArchivo(MultipartFile archivo);

    /**
     * Elimina un archivo basado en su ruta o URL.
     */
    void eliminarArchivo(String nombreArchivo);
}