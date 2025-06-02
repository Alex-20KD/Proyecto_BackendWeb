package com.adopcion.multimedia;

import static org.junit.jupiter.api.Assertions.assertNotNull;

import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.context.SpringBootTest;

import com.adopcion.multimedia.controller.MultimediaController;

/**
 * Clase de prueba para la aplicación Spring Boot.
 * Verifica que el contexto de la aplicación se carga correctamente.
 */
@SpringBootTest
class AppTest {

    // Inyectamos un controlador para verificar que el contexto se cargó
    @Autowired
    private MultimediaController controller;

    /**
     * Una prueba simple que verifica que el contexto de Spring se carga
     * y que nuestro controlador ha sido creado e inyectado correctamente.
     */
    @Test
    void contextLoads() {
        // La prueba es exitosa si el controlador no es nulo.
        assertNotNull(controller, "El controlador no debería ser nulo, el contexto falló en cargar.");
    }
}