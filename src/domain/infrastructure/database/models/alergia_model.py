from sqlalchemy import Column, Integer, String, Date, ForeignKey
from sqlalchemy.orm import relationship
from infrastructure.database.config import Base # Asegúrate de que 'config' existe y 'Base' está definida

class AlergiaModel(Base):
    __tablename__ = "alergias"

    id = Column(Integer, primary_key=True, index=True)
    descripcion = Column(String, nullable=False)
    tipo = Column(String, nullable=False)
    gravedad = Column(String, nullable=False)
    fecha_deteccion = Column(Date, nullable=False)
    mascota_id = Column(Integer, ForeignKey("mascotas.id"), nullable=False)

    # Define la relación inversa con MascotaModel
    mascota = relationship("MascotaModel", back_populates="alergias")