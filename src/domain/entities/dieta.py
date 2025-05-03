from typing import Optional
from pydantic import BaseModel

class Dieta(BaseModel):
    id: Optional[int] = None
    descripcion: str
    frecuencia: str
    cantidad: str
    observaciones: Optional[str] = None

    class Config:
        from_attributes = True