from sqlalchemy import Column, Integer, String, Date, ForeignKey
from sqlalchemy.orm import relationship
from infrastructure.database.config import Base

class VacunaModel(Base):
    __tablename__ = "vacunas"

    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String, nullable=False)
    fecha_aplicacion = Column(Date, nullable=False)
    dosis = Column(String, nullable=False)
    lote = Column(String, nullable=False)
    mascota_id = Column(Integer, ForeignKey("mascotas.id"), nullable=False)

    mascota = relationship("MascotaModel", back_populates="vacunas")