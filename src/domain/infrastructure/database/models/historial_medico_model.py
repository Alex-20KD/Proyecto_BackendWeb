from sqlalchemy import Column, Integer, String, Date, ForeignKey
from sqlalchemy.orm import relationship
from infrastructure.database.config import Base

class HistorialMedicoModel(Base):
    __tablename__ = "historiales_medicos"

    id = Column(Integer, primary_key=True, index=True)
    descripcion = Column(String, nullable=False)
    fecha_visita = Column(Date, nullable=False)
    veterinario = Column(String, nullable=False)
    tratamiento = Column(String, nullable=False)
    mascota_id = Column(Integer, ForeignKey("mascotas.id"), nullable=False)

    mascota = relationship("MascotaModel", back_populates="historiales")