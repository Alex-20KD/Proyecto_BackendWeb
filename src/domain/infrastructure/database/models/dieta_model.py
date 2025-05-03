from sqlalchemy import Column, Integer, String, ForeignKey
from sqlalchemy.orm import relationship
from infrastructure.database.config import Base

class DietaModel(Base):
    __tablename__ = "dietas"

    id = Column(Integer, primary_key=True, index=True)
    descripcion = Column(String, nullable=False)
    frecuencia = Column(String, nullable=False)
    cantidad = Column(String, nullable=False)
    observaciones = Column(String, nullable=True)
    mascota_id = Column(Integer, ForeignKey("mascotas.id"), nullable=False)

    mascota = relationship("MascotaModel", back_populates="dietas")