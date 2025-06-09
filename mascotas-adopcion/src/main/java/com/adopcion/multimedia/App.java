package com.adopcion.multimedia;

import java.util.InputMismatchException;
import java.util.List;
import java.util.Scanner;

public class App {

    private static final Scanner scanner = new Scanner(System.in);

    public static void main(String[] args) {
        MultimediaDAO dao = new MultimediaDAO();
        boolean continuar = true;

        while (continuar) {
            System.out.println("\n--- Sistema de Adopción - Multimedia ---");
            System.out.println("1. Agregar archivo multimedia");
            System.out.println("2. Listar todos los archivos");
            System.out.println("3. Buscar por ID de mascota");
            System.out.println("4. Eliminar archivo por ID");
            System.out.println("5. Salir");
            System.out.print("Seleccione una opción: ");
            String opcion = scanner.nextLine().trim();

            switch (opcion) {
                case "1":
                    agregarMultimedia(dao);
                    break;
                case "2":
                    listarTodos(dao);
                    break;
                case "3":
                    buscarPorMascotaId(dao);
                    break;
                case "4":
                    eliminarPorId(dao);
                    break;
                case "5":
                    continuar = false;
                    System.out.println(" Saliendo del sistema...");
                    break;
                default:
                    System.out.println(" Opción inválida. Intente de nuevo.");
            }
        }

        scanner.close();
    }

    private static void agregarMultimedia(MultimediaDAO dao) {
        try {
            System.out.print("ID: ");
            int id = Integer.parseInt(scanner.nextLine());

            System.out.print("ID de la mascota: ");
            int mascotaId = Integer.parseInt(scanner.nextLine());

            System.out.print("Tipo (imagen/video): ");
            String tipo = scanner.nextLine().trim().toLowerCase();
            if (!tipo.equals("imagen") && !tipo.equals("video")) {
                System.out.println(" Tipo inválido. Debe ser 'imagen' o 'video'.");
                return;
            }

            System.out.print("URL: ");
            String url = scanner.nextLine().trim();
            if (!url.startsWith("http")) {
                System.out.println(" URL inválida. Debe comenzar con http o https.");
                return;
            }

            Multimedia nuevo = new Multimedia(id, mascotaId, tipo, url);
            dao.agregarMultimedia(nuevo);
            System.out.println("Archivo agregado correctamente.");
        } catch (NumberFormatException e) {
            System.out.println(" Error: debe ingresar un número válido para ID o mascotaId.");
        }
    }

    private static void listarTodos(MultimediaDAO dao) {
        List<Multimedia> todos = dao.obtenerTodos();
        if (todos.isEmpty()) {
            System.out.println(" No hay archivos multimedia registrados.");
        } else {
            todos.forEach(System.out::println);
        }
    }

    private static void buscarPorMascotaId(MultimediaDAO dao) {
        try {
            System.out.print("Ingrese el ID de la mascota: ");
            int id = Integer.parseInt(scanner.nextLine());
            List<Multimedia> resultados = dao.buscarPorMascotaId(id);
            if (resultados.isEmpty()) {
                System.out.println(" No se encontraron archivos para esa mascota.");
            } else {
                resultados.forEach(System.out::println);
            }
        } catch (NumberFormatException e) {
            System.out.println(" Error: debe ingresar un número válido.");
        }
    }

    private static void eliminarPorId(MultimediaDAO dao) {
        try {
            System.out.print("Ingrese el ID del archivo a eliminar: ");
            int id = Integer.parseInt(scanner.nextLine());
            dao.eliminarPorId(id);
            System.out.println(" Archivo eliminado si existía.");
        } catch (NumberFormatException e) {
            System.out.println(" Error: debe ingresar un número válido.");
        }
    }
}
