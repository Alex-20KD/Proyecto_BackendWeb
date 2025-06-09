package com.adopcion.multimedia;

public class Multimedia {
    private int id;
    private int mascotaId;
    private String tipo;
    private String url;

    public Multimedia(int id, int mascotaId, String tipo, String url) {
        this.id = id;
        this.mascotaId = mascotaId;
        this.tipo = tipo;
        this.url = url;
    }

    // Getters
    public int getId() {
        return id;
    }

    public int getMascotaId() {
        return mascotaId;
    }

    public String getTipo() {
        return tipo;
    }

    public String getUrl() {
        return url;
    }

    // Setters
    public void setId(int id) {
        this.id = id;
    }

    public void setMascotaId(int mascotaId) {
        this.mascotaId = mascotaId;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public void setUrl(String url) {
        this.url = url;
    }

    @Override
    public String toString() {
        return "Multimedia{" +
                "id=" + id +
                ", mascotaId=" + mascotaId +
                ", tipo='" + tipo + '\'' +
                ", url='" + url + '\'' +
                '}';
    }
}
