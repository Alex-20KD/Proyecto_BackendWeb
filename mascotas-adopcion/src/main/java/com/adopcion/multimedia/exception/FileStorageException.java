package com.adopcion.multimedia.exception;

/**
 * Excepción que se lanza cuando ocurre un error durante el almacenamiento
 * o la eliminación de un archivo físico.
 */
public class FileStorageException extends RuntimeException {

    public FileStorageException(String message) {
        super(message);
    }

    public FileStorageException(String message, Throwable cause) {
        super(message, cause);
    }
}