package com.adopcion.multimedia;

public class TipoRecurso {
    private int id;
    private String nombre;
    private String formato;

    public TipoRecurso(int id, String nombre, String formato) {
        this.id = id;
        this.nombre = nombre;
        this.formato = formato;
    }

    // Getters
    public int getId() {
        return id;
    }

    public String getNombre() {
        return nombre;
    }

    public String getFormato() {
        return formato;
    }

    // Setters
    public void setId(int id) {
        this.id = id;
    }

    public void setNombre(String nombre) {
        this.nombre = nombre;
    }

    public void setFormato(String formato) {
        this.formato = formato;
    }

    @Override
    public String toString() {
        return "TipoRecurso{" +
                "id=" + id +
                ", nombre='" + nombre + '\'' +
                ", formato='" + formato + '\'' +
                '}';
    }
}
