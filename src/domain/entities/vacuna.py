from typing import Optional
from datetime import date
from pydantic import BaseModel

class Vacuna(BaseModel):
    id: Optional[int] = None
    nombre: str
    fecha_aplicacion: date
    dosis: str
    lote: str

    class Config:
        from_attributes = True