from typing import Optional
from datetime import date
from pydantic import BaseModel

class Alergia(BaseModel):
    id: Optional[int] = None
    descripcion: str
    tipo: str
    gravedad: str
    fecha_deteccion: date

    class Config:
        from_attributes = True