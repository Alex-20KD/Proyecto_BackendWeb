from abc import ABC, abstractmethod
from typing import List, Optional
from domain.entities.historial_medico import HistorialMedico

class HistorialMedicoRepository(ABC):
    @abstractmethod
    async def get_by_id(self, id: int) -> Optional[HistorialMedico]: pass
    @abstractmethod
    async def get_all(self) -> List[HistorialMedico]: pass
    @abstractmethod
    async def create(self, historial_medico: HistorialMedico) -> HistorialMedico: pass
    @abstractmethod
    async def update(self, id: int, historial_medico: HistorialMedico) -> Optional[HistorialMedico]: pass
    @abstractmethod
    async def delete(self, id: int) -> bool: pass