from pydantic import BaseModel, Field
from typing import Optional

class MascotaBase(BaseModel):
    nombre: str = Field(..., description="Nombre de la mascota")
    tipo: Optional[str] = Field(None, description="Tipo de mascota (ej. perro, gato)")
    edad: Optional[int] = Field(None, description="Edad de la mascota en años")

class MascotaCreate(MascotaBase):
    """Modelo para crear una nueva mascota (sin ID, ya que lo genera la DB)."""
    pass

class Mascota(MascotaBase):
    """Modelo completo de la mascota con ID."""
    id: Optional[int] = None # ID es opcional al crear, pero existe en la DB

    class Config:
        from_attributes = True # Permite crear un modelo desde atributos ORM (ej. de MascotaModel)
        # from_orm = True # Para versiones anteriores de Pydantic
        