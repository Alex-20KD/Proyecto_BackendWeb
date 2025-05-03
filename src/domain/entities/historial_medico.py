from pydantic import BaseModel, Field
from typing import Optional
from datetime import date

class HistorialMedicoBase(BaseModel):
    descripcion: str = Field(..., description="Resumen o diagnóstico del historial médico")
    fecha_visita: date = Field(default_factory=date.today, description="Fecha de la consulta")
    veterinario: str = Field(..., description="Nombre del veterinario")
    tratamiento: str = Field(..., description="Descripción del tratamiento aplicado")
    mascota_id: int = Field(..., description="ID de la mascota asociada a este historial")

class HistorialMedicoCreate(HistorialMedicoBase):
    pass

class HistorialMedico(HistorialMedicoBase):
    id: Optional[int] = None

    class Config:
        from_attributes = True