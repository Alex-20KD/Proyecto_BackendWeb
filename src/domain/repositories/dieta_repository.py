from abc import ABC, abstractmethod
from typing import List, Optional
from domain.entities.dieta import Dieta

class DietaRepository(ABC):
    @abstractmethod
    async def get_by_id(self, id: int) -> Optional[Dieta]: pass
    @abstractmethod
    async def get_all(self) -> List[Dieta]: pass
    @abstractmethod
    async def create(self, dieta: Dieta) -> Dieta: pass
    @abstractmethod
    async def update(self, id: int, dieta: Dieta) -> Optional[Dieta]: pass
    @abstractmethod
    async def delete(self, id: int) -> bool: pass