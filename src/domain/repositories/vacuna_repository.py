from abc import ABC, abstractmethod
from typing import List, Optional
from domain.entities.vacuna import Vacuna

class VacunaRepository(ABC):
    @abstractmethod
    async def get_by_id(self, id: int) -> Optional[Vacuna]: pass
    @abstractmethod
    async def get_all(self) -> List[Vacuna]: pass
    @abstractmethod
    async def create(self, vacuna: Vacuna) -> Vacuna: pass
    @abstractmethod
    async def update(self, id: int, vacuna: Vacuna) -> Optional[Vacuna]: pass
    @abstractmethod
    async def delete(self, id: int) -> bool: pass