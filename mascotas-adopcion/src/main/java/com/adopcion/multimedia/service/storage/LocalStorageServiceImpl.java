package com.adopcion.multimedia.service.storage;

import com.adopcion.multimedia.exception.FileStorageException;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import java.io.IOException;
import java.io.InputStream;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.UUID;

@Service
public class LocalStorageServiceImpl implements FileStorageService {

    // La carpeta raíz donde se guardarán los archivos
    private final Path rootLocation;

    public LocalStorageServiceImpl() {
        // Define la ruta. Puedes cambiar "uploads" por cualquier otra carpeta.
        this.rootLocation = Paths.get("uploads");
        try {
            // Crea el directorio si no existe
            Files.createDirectories(rootLocation);
        } catch (IOException e) {
            throw new FileStorageException("No se pudo crear el directorio de almacenamiento", e);
        }
    }

    @Override
    public String guardarArchivo(MultipartFile archivo) {
        if (archivo.isEmpty()) {
            throw new FileStorageException("No se puede guardar un archivo vacío.");
        }

        // Genera un nombre de archivo único para evitar colisiones
        String nombreOriginal = archivo.getOriginalFilename();
        String extension = nombreOriginal.substring(nombreOriginal.lastIndexOf("."));
        String nombreUnico = UUID.randomUUID().toString() + extension;

        try (InputStream inputStream = archivo.getInputStream()) {
            Path destinationFile = this.rootLocation.resolve(Paths.get(nombreUnico))
                                     .normalize().toAbsolutePath();

            // Copia el contenido del archivo a su destino final
            Files.copy(inputStream, destinationFile, StandardCopyOption.REPLACE_EXISTING);
            
            // Devuelve el nombre del archivo para guardarlo en la base de datos
            return nombreUnico;

        } catch (IOException e) {
            throw new FileStorageException("Falló al guardar el archivo.", e);
        }
    }

    @Override
    public void eliminarArchivo(String nombreArchivo) {
        try {
            Path file = rootLocation.resolve(nombreArchivo);
            Files.deleteIfExists(file);
        } catch (IOException e) {
            throw new FileStorageException("No se pudo eliminar el archivo", e);
        }
    }
}