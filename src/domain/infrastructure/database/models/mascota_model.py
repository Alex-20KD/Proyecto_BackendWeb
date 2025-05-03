from sqlalchemy import Column, Integer, String
from sqlalchemy.orm import relationship
from infrastructure.database.config import Base

class MascotaModel(Base):
    __tablename__ = "mascotas"

    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String, index=True, nullable=False)
    tipo = Column(String, nullable=True)
    edad = Column(Integer, nullable=True)

    # Relaciones inversas para acceder a datos relacionados desde Mascota
    historiales = relationship("HistorialMedicoModel", back_populates="mascota")
    vacunas = relationship("VacunaModel", back_populates="mascota")
    dietas = relationship("DietaModel", back_populates="mascota")
    alergias = relationship("AlergiaModel", back_populates="mascota")