package com.adopcion.multimedia;

import com.google.gson.reflect.TypeToken;
import com.google.gson.Gson;

import java.io.*;
import java.lang.reflect.Type;
import java.util.ArrayList;
import java.util.List;

public class MultimediaDAO {
    private List<Multimedia> archivos = new ArrayList<>();
    private final String ARCHIVO_JSON = "multimedia.json";
    private final Gson gson = new Gson();

    public MultimediaDAO() {
        cargarDesdeArchivo();
    }

    public void agregarMultimedia(Multimedia m) {
        archivos.add(m);
        guardarEnArchivo();
    }

    public List<Multimedia> obtenerTodos() {
        return archivos;
    }

    public List<Multimedia> buscarPorMascotaId(int mascotaId) {
        List<Multimedia> resultados = new ArrayList<>();
        for (Multimedia m : archivos) {
            if (m.getMascotaId() == mascotaId) {
                resultados.add(m);
            }
        }
        return resultados;
    }

    public void eliminarPorId(int id) {
        archivos.removeIf(m -> m.getId() == id);
        guardarEnArchivo();
    }

    private void guardarEnArchivo() {
        try (Writer writer = new FileWriter(ARCHIVO_JSON)) {
            gson.toJson(archivos, writer);
        } catch (IOException e) {
            System.out.println("Error al guardar en JSON: " + e.getMessage());
        }
    }

    private void cargarDesdeArchivo() {
        File archivo = new File(ARCHIVO_JSON);
        if (!archivo.exists()) return;

        try (Reader reader = new FileReader(archivo)) {
            Type listType = new TypeToken<ArrayList<Multimedia>>() {}.getType();
            archivos = gson.fromJson(reader, listType);
        } catch (IOException e) {
            System.out.println("Error al cargar desde JSON: " + e.getMessage());
        }
    }
}
