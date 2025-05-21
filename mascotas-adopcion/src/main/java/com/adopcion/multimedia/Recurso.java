package com.adopcion.multimedia;

import java.util.Date;

public class Recurso {
    private int id;
    private int multimediaId;
    private int tipoRecursoId;
    private String url;
    private String descripcion;
    private Date fechaSubida;

    public Recurso(int id, int multimediaId, int tipoRecursoId, String url, String descripcion, Date fechaSubida) {
        this.id = id;
        this.multimediaId = multimediaId;
        this.tipoRecursoId = tipoRecursoId;
        this.url = url;
        this.descripcion = descripcion;
        this.fechaSubida = fechaSubida;
    }

    // Getters
    public int getId() {
        return id;
    }

    public int getMultimediaId() {
        return multimediaId;
    }

    public int getTipoRecursoId() {
        return tipoRecursoId;
    }

    public String getUrl() {
        return url;
    }

    public String getDescripcion() {
        return descripcion;
    }

    public Date getFechaSubida() {
        return fechaSubida;
    }

    // Setters
    public void setId(int id) {
        this.id = id;
    }

    public void setMultimediaId(int multimediaId) {
        this.multimediaId = multimediaId;
    }

    public void setTipoRecursoId(int tipoRecursoId) {
        this.tipoRecursoId = tipoRecursoId;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    public void setDescripcion(String descripcion) {
        this.descripcion = descripcion;
    }

    public void setFechaSubida(Date fechaSubida) {
        this.fechaSubida = fechaSubida;
    }

    @Override
    public String toString() {
        return "Recurso{" +
                "id=" + id +
                ", multimediaId=" + multimediaId +
                ", tipoRecursoId=" + tipoRecursoId +
                ", url='" + url + '\'' +
                ", descripcion='" + descripcion + '\'' +
                ", fechaSubida=" + fechaSubida +
                '}'; 
    }
}
